<template>
    <Layout>
        <div class="w-full px-6 py-12">
            <!-- Banner Section -->
            <div class="relative mb-12">
                <div class="relative overflow-hidden rounded-lg">
                    <img :src="profilePhotoUrl" alt="Warren Davey" class="w-full h-80 object-cover rounded-lg">
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <div class="text-white px-6">
                        <h1 class="text-4xl font-bold mb-4">Warren Davey</h1>
                        <p class="text-xl mb-4">A fullstack developer specializing in Laravel + Vue frameworks, focusing on writing clean and efficient code.</p>
                        <p class="text-xl">My aim is to learn and stay up to date with best practices and develop elegant solutions.</p>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="mb-12">
                <div class="text-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h1 class="text-3xl font-bold mb-6">About</h1>
                    <p class="mb-4">I studied at the University of Gloucester, graduating with a bachelor's honors degree in Interactive Game Design.</p>
                    <p>I started my web developer career in 2019, initially working on simple bug fixes using vanilla HTML, CSS, and JavaScript.</p>
                </div>
            </div>

            <!-- Skills Section -->
            <div class="mb-12">
                <div class="text-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h1 class="text-3xl font-bold mb-6">Skills</h1>
                    <ul class="list-disc list-inside space-y-3 text-lg">
                        <li>Vue</li>
                        <li>Laravel</li>
                        <li>Inertia</li>
                        <li>HTML</li>
                        <li>CSS</li>
                        <li>Javascript</li>
                    </ul>
                </div>
            </div>

            <!-- Projects Section -->
            <div class="mb-12">
                <div class="text-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h1 class="text-3xl font-bold mb-6">Projects</h1>
                    <!-- Project content goes here -->
                </div>
            </div>

        </div>

    </Layout>
</template>

<script>
import Layout from "@/Shared/Layout.vue"

export default {
    components: {
        Layout
    },

    props: {
        profilePhotoUrl: {
            type: String
        }
    }
}
</script>
<style scoped>
/* Full-width container with image on the left and text on the right */
.content-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
    background-color: black;
}

/* Wrapper for the image to ensure proper sizing and spacing */
.banner-image-wrapper {
    flex-shrink: 0; /* Prevent the image from shrinking */
}

.banner-image {
    width: 200px;
    height: 200px;
    border-radius: 25%;
    object-fit: cover;
    border: 2px solid #ddd;
}

/* Styling for the text area */
.content-text {
    flex: 1;
    margin-left: 20px;
}

.content-text h1 {
    margin: 0;
    font-size: 24px;
    color: white;
}

.content-text p {
    margin: 5px 0 0;
    font-size: 16px;
    color: white;
}
</style>
