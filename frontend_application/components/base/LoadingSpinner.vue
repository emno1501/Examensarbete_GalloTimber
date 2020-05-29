<template>
    <b-spinner 
    label="Spinning" 
    variant="secondary">
        <span class="sr-only">Laddar...</span>
    </b-spinner>
</template>

<style lang="scss" scoped>
@import '~/assets/scss/abstracts/_variables.scss';
    .spinner-border {
        width: 60px;
        height: 60px;
        margin: 150px auto;
    }
</style>

<script>
export default {
    props: {
        route: String
    }
}
</script>