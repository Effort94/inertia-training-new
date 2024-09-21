<?php

namespace Task;

use App\Http\Services\TaskService;
use App\Models\Priority;
use App\Models\Task;
use Mockery;
use Str;
use Tests\TestCase;

class TaskControllerTest extends Testcase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->routes = [
            'store' => 'tasks',
        ];

        $this->params = [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'priority' => Priority::InRandomOrder()->first()->id
        ];
    }

    public function testGetFilters()
    {
        $expected_filters = [Priority::class => 'priorities'];

        // Attempt to get the filters data.
        $response = $this->get("tasks/index-data/filters");
        $response->assertStatus(200);

        $actual_items = $response->getOriginalContent();

        foreach ($expected_filters as $model => $expected_filter) {
            $expected_items = $model::all()->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            });

            $this->assertEquals($expected_items, $actual_items[$expected_filter]);
        }
    }

    public function testStore()
    {
        // Store task
        $this->post($this->routes['store'], $this->params)->assertSessionDoesntHaveErrors();

        // Fetch the latest task
        $expected = $this->params;
        $actual = Task::latest()->first();

        // Check Task matches expected data
        $this->assertEquals($expected['title'], $actual->title);
        $this->assertEquals($expected['description'], $actual->description);
        $this->assertEquals($expected['priority'], $actual->priority->id);

        $this->app->instance(TaskService::class, Mockery::mock(TaskService::class, function ($mock) {
            $mock->shouldReceive('save')->andThrow(new \Exception('Error occurred'));
        }));

        $this->post($this->routes['store'], $this->params)
            ->assertRedirect()
            ->assertSessionHas('error', 'Failed to create task. Please try again.');
    }

    public function testUpdate()
    {
        // Store task
        $task = Task::factory()->create();

        // New data to update task with
        $params = [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'priority' => Priority::inRandomOrder()->where('id', '!=', $task->priority->id)->first()->id,
        ];

        $url = "/tasks/{$task->id}";
        $this->put($url, $params)->assertSessionDoesntHaveErrors();
        $task->refresh();

        // Assert Task has updated
        $this->assertEquals($params['title'], $task->title);
        $this->assertEquals($params['description'], $task->description);
        $this->assertEquals($params['priority'], $task->priority->id);

        $this->app->instance(TaskService::class, Mockery::mock(TaskService::class, function ($mock) {
            $mock->shouldReceive('save')->andThrow(new \Exception('Error occurred'));
        }));

        $this->put($url, $params)
            ->assertRedirect()
            ->assertSessionHas('error', 'Failed to update task. Please try again.');
    }

    public function testDestroy()
    {
        // Store task
        $this->post($this->routes['store'], $this->params)->assertSessionDoesntHaveErrors();
        $task = Task::inRandomOrder()->first();

        // Destroy task
        $url = "/tasks/{$task->id}";
        $this->delete($url)->assertSessionDoesntHaveErrors();

        // Check task has been deleted
        $this->assertEmpty(Task::where("id", $task->id)->get());
    }

    // Validation

    public function testValidateRequired()
    {
        $fields = ['title', 'description', 'priority'];

        foreach ($fields as $field) {
            unset($this->params[$field]);

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The {$field} field is required."]]);
        }
    }

    public function testValidateString()
    {
        $fields = ['title', 'description'];

        foreach ($fields as $field) {
            $this->params[$field] = rand(1, 10);

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The {$field} field must be a string."]]);
        }
    }

    public function testValidateMax()
    {
        $fields = ['title', 'description'];

        foreach ($fields as $field) {
            $this->params[$field] = Str::random(256);

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The {$field} field must not be greater than 255 characters."]]);
        }
    }

    public function testValidateRuleIn()
    {
        $fields = ['priority'];

        foreach($fields as $field) {
            $this->params[$field] = Str::random();

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The selected {$field} is invalid."]]);
        }
    }
}
