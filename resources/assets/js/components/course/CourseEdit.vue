<template>
    <CourseForm v-bind:id="this.$route.params.id"></CourseForm>
</template>

<script>
    import CourseForm from './CourseForm'

    export default {
        components: {
            CourseForm
        },

        created() {
            console.debug(this.$route)
        }
    }
</script>

<style scoped>

</style>