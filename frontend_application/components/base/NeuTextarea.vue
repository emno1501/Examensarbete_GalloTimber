<template>
    <b-form-textarea
    :id="id"
    v-bind:value="value"
    v-on:input="updateValue"
    ref="textarea"
    rows="5">
    </b-form-textarea>
</template>

<script>
export default {
    props: {
        id: {
            type: String
        },
        value: {
            type: String
        }
    },
    methods: {
        updateValue(evt) {
            this.$emit('input', evt);
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '~/assets/scss/abstracts/_variables.scss';

    textarea {
        border: 2px solid $gallo-primary;
        border-radius: 5px;
        background-color: #ebebeb;
        box-shadow: inset 4px 4px 5px #bababa, 
                    inset -4px -4px 5px #ffffff;
    }
    textarea:focus {
        border: 2px solid $gallo-secondary;
        border-radius: 5px;
        background-color: #ebebeb;
        box-shadow: inset 4px 4px 5px #bababa, 
                    inset -4px -4px 5px #ffffff;
    }
</style>