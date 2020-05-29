<template>
    <b-form-file 
        accept="application/pdf"
        :id="id" 
        :value="formFile.file"
        v-on:input="updateValue"
        ref="fileInput" 
        class="file-input"
        placeholder="Välj fil eller dra och släpp"
        drop-placeholder="Släpp filen här"
        browse-text="Bläddra"
        required
    ></b-form-file>
</template>

<script>
export default {
    props: {
        id: {
            type: String
        },
        formFile: {
            type: Object, 
            default: () => {}
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


</style>