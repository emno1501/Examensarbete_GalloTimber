<template>
    <b-button :to="route" variant="primary" pill>
        <slot/>
    </b-button>
</template>

<script>
export default {
    props: {
        route: String
    }
}
</script>

<style lang="scss" scoped>
@import '~/assets/scss/abstracts/_variables.scss';
    a,
    button {
        letter-spacing: 0.02em;
        border: none;
        margin-top: 30px;
        padding: 10px 20px;
        color: black;
    }
    .wide-button {
        width: 100%;
    }
    a:hover,
    a:focus,
    a:active,
    button:hover,
    button:focus,
    button:active {
        background-color: $gallo-primary !important;
        box-shadow: inset 5px 5px 9px #6e8f17, 
                    inset -5px -5px 9px #baf327 !important;
        color: black !important;
    }
</style>
