<?php

namespace Feature\Task;

use App\Models\Priority;
use App\Models\Task;
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

}
