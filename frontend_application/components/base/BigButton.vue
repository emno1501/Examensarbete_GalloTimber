<template>
    <b-button :to="route" variant="primary">
        <p>
        <slot/>
        </p>
        <img src="@/static/images/arrow_black.svg" alt="Vidare" />
    </b-button>
</template>

<style lang="scss" scoped>
@import '~/assets/scss/abstracts/_variables.scss';
    a {
        letter-spacing: 0.02em;
        border: none;
        border-radius: 10px;
        margin-bottom: 20px;
        padding: 25px;
        font-size: 2.4rem;
        width: 100%;
        text-align: left;
        color: black;
        p {
            float: left;
            width: 90%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 0 !important;
        }
        img {
            width: auto;
            height: 35px;
            float: right;
        }
    }
    a:hover,
    a:focus,
    a:active {
        background-color: $gallo-primary !important;
        box-shadow: inset 5px 5px 9px #6e8f17, 
                    inset -5px -5px 9px #baf327 !important;
        color: black !important;
    }
</style>

<script>
export default {
    props: {
        route: String
    }
}
</script>