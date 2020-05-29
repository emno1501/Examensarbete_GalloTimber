<template>
    <b-button href="#top" variant="secondary">
        <img src="@/static/images/arrow_white.svg" alt="Till toppen" />
    </b-button>
</template>

<style lang="scss" scoped>
@import '~/assets/scss/abstracts/_variables.scss';
    a {
        width: 60px;
        height: 60px;
        padding: 18px 10px;
        justify-self: center;
        letter-spacing: 0.02em;
        border: none;
        border-radius: 5px;
        transition: none;
    }
    a:hover,
    a:focus,
    a:active {
        background-color: $gallo-secondary !important;
        box-shadow: inset 5px 5px 8px #a76500, 
                    inset -5px -5px 8px #ffa800 !important;
        padding: 18px 12px !important;
    }
</style>

<script>
export default {
    props: {
        route: String
    }
}
</script>