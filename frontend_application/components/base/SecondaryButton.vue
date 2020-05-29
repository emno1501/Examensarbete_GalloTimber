<template>
    <b-button variant="secondary" pill v-on:click="emitClick">
        <slot/>
    </b-button>
</template>

<script>
export default {
    props: {
        route: String
    },
    methods: {
        emitClick() {
            this.$emit('back');
        }
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
        background-color: $gallo-secondary !important;
        box-shadow: inset 5px 5px 8px #a76500, 
                    inset -5px -5px 8px #ffb100 !important;
        color: white !important;
    }
</style>

