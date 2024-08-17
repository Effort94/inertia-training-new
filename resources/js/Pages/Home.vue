<template>
    <Layout>
        <div class="content-container">
            <div class="banner-image-wrapper">
                <img :src="profilePhotoUrl" alt="Warren Davey" class="banner-image">
            </div>
            <div class="content-text">
                <h1><b>Warren Davey</b></h1>
                <p>A Fullstack developer specializing in Laravel + Vue frameworks, focusing on writing clean and efficient code.</p>
                <p> My aim is to learn and stay up to date with best practices and develop elegant solutions</p>
            </div>
        </div>

        <div class="content-container">
            <div class="content-text">
                <h1> About </h1>

                   <p>I studied at the University of Gloucester, graduating with a bachelors honors degree in Interactive Game Design.</p>
                    <p>I started my web developer career in 2019. Firstly fixing simple bug fixes using vanilla HTML, CSS, Javascript.</p>

            </div>
        </div>

        <div class="content-container">
            <div class="content-text">
                <h1> Skills </h1>
            </div>
        </div>

        <div class="content-container">
            <div class="content-text">
                <h1> Projects </h1>
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
