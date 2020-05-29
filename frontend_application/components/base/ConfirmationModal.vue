<template>
    <b-modal :id="id" hide-footer hide-header>
        <slot/>
    </b-modal>
</template>

<script>
export default {
    props: {
        id: {
            type: String
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~/assets/scss/abstracts/_variables.scss';

    div {
        text-align: center;
        font-family: $headings-font-family;
        font-weight: $headings-font-weight;
    }
</style>