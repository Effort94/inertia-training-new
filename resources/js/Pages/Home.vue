<template>
    <Layout>
        <section class="flex-grow flex flex-col text-white">
            <!-- Profile Section -->
            <div class="flex-grow flex justify-center items-center overflow-hidden bg-gray-800 p-12">
                <div class="w-full max-w-6xl flex flex-col lg:flex-row items-center">
                    <!-- Profile Picture & Social Links -->
                    <div class="flex flex-col justify-center lg:justify-start items-center space-y-4">
                        <img :src="profilePhotoUrl" alt="me" class="object-cover h-96 w-96 rounded-full shadow-lg">

                        <div class="flex space-x-4">
                            <a href="https://www.linkedin.com/in/warren-davey-469185166/" target="_blank" class="text-white hover:text-gray-300">
                                <i class="fab fa-linkedin text-3xl"></i>
                            </a>

                            <a href="https://github.com/Effort94" target="_blank" class="text-white hover:text-gray-300">
                                <i class="fab fa-github text-3xl"></i>
                            </a>
                        </div>
                    </div>

                    <!-- About Me, Skills, and Showcase -->
                    <div class="lg:w-2/3 flex flex-col justify-center items-center lg:items-start lg:pl-12 mt-6">
                        <h1 class="text-4xl font-bold mb-2">Hi, I'm Warren Davey</h1>
                        <p class="text-lg mb-4">A fullstack developer specializing in Laravel + Vue frameworks, focusing on writing clean and efficient code.</p>
                        <p class="text-lg mb-4">I believe anything can be created with code, no matter the complexity, design or uniqueness.</p>
                        <p class="text-lg mb-6">My aim is to grow and keep up to date with best practices. Developing elegant but simple solutions for whatever problem arises.</p>

                        <!-- Skills Section -->
                        <div id="skills" class="w-full bg-gray-700 p-6 rounded-lg mb-6">
                            <h2 class="text-3xl font-bold text-center lg:text-left mb-6 text-white">Skills</h2>
                            <div class="flex justify-center lg:justify-start space-x-8">
                                <div v-for="skill in skills" :key="skill.name">
                                    <div class="text-center text-5xl">
                                        <i :class="skill.class"></i>
                                        <h3 class="text-xl font-bold text-white">{{ skill.name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center items-center space-x-4 mt-6">
                            <button @click="downloadCV"
                                    class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                                Download CV
                            </button>
                            <NavLink class="bg-green-500 font-semibold py-2 px-4 rounded-lg hover:bg-green-600" href="/tasks">
                                View Showcase
                            </NavLink>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from "@/Shared/Layout.vue"
import Button from "@/Shared/Form/Button.vue"
import NavLink from "../Shared/NavLink.vue";
import axios from "axios";

export default {
    components: {
        NavLink,
        Layout,
        Button
    },

    props: {
        profilePhotoUrl: {
            type: String
        }
    },

    data() {
        return {
            skills: [
                { name: 'Laravel', class: 'fas fa-code text-purple-400 mb-2' },
                { name: 'Vue.js', class: 'fas fa-code text-green-400 mb-2' },
                { name: 'Tailwind CSS', class: 'fas fa-desktop text-purple-400 mb-2' },
                { name: 'MySQL', class: 'fas fa-database text-green-400 mb-2' },
                { name: 'Docker', class: 'fas fa-cloud text-purple-400 mb-2' },
            ],
        }
    },

    methods: {
        async downloadCV() {
            try {
                const response = await axios.get('/download-cv', {
                    responseType: 'blob'
                });

                const blob = new Blob([response.data], {type: 'application/pdf'});
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'cv.pdf';
                link.click();
            } catch (error) {
                console.error('Error downloading CV:', error);
            }
        }
    }
}
</script>
