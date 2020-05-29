<template>
    <div><slot/></div>
</template>

<style lang="scss" scoped>
    @import '~/assets/scss/abstracts/_variables.scss';
    div {
            background-color: $gallo-light;
            border-radius: 100px;
            box-shadow: 2px 2px 5px inset #c3c3c3, 
                        -3px -3px 5px inset #ffffff;
            width: 65px;
            height: 65px;
            padding: 12px;
            margin: 0 auto 15px auto;
        }
</style>