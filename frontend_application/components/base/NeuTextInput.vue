<template>
    <b-form-input
    :id="id"
    v-bind:value="value"
    v-on:input="updateValue"
    ref="textInput"
    :type="type"
    :name="name"
    :autocomplete="autoComplete"
    required>
    </b-form-input>
</template>

<script>
export default {
    props: {
        id: {
            type: String
        },
        value: {
            type: String
        },
        type: {
            type: String
        },
        name: {
            type: String
        },
        autoComplete: {
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

    input {
        border: 2px solid $gallo-primary;
        border-radius: 5px;
        background-color: #ebebeb;
        box-shadow: inset 4px 4px 5px #bababa, 
                    inset -4px -4px 5px #ffffff;

    }
    input:focus {
        border: 2px solid $gallo-secondary;
        border-radius: 5px;
        background-color: #ebebeb;
        box-shadow: inset 4px 4px 5px #bababa, 
                    inset -4px -4px 5px #ffffff;
    }
</style>