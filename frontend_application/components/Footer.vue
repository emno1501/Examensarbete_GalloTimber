<template>
    <footer>
        <b-container fluid>
            <b-row class="px-4 px-md-0">
                <!-- Logga -->
                <b-col cols="12" lg="3" order="1" class="logoBox">
                    <img 
                    v-if="content"
                    :src="content.logotyp.url" 
                    :alt="content.logotyp.alt" />
                </b-col>
                <!-- Länkar -->
                <b-col cols="8" md="3" lg="2" order="2" class="mb-5 mb-md-0">
                    <h2 v-if="siteData != null" v-html="siteData.name"/>
                    <b-list-group flush v-if="links.length > 0">
                        <span
                        v-for="link in links"
                        :key="link.title">
                            <b-list-group-item 
                            v-if="link.type == 'custom'"
                            :href="link.url"
                            v-html="link.title"
                            target="_blank"></b-list-group-item>
                            <b-list-group-item 
                            v-else
                            :to="'/' + link.slug"
                            v-html="link.title"></b-list-group-item>
                        </span>
                    </b-list-group>
                </b-col>
                <!--Kontakt-->
                <b-col cols="8" md="3" lg="2" order="4" order-md="3" class="mb-5 mb-md-0">
                    <h2 v-html="content.footer_innehall.kontakt.rubrik"/>
                    <b-list-group flush>
                        <b-list-group-item  
                        v-for="items in content.footer_innehall.kontakt.innehall" 
                        :key="items.text"
                        :href="items.lank"
                        target="_blank"
                        v-html="items.text"></b-list-group-item>
                    </b-list-group>
                </b-col>
                <!--Adress-->
                <b-col cols="8" md="4" lg="2" order="5" order-md="4">
                    <h2 v-html="content.footer_innehall.adress.rubrik"/>
                    <b-list-group flush>
                        <b-list-group-item  
                        v-for="items in content.footer_innehall.adress.innehall" 
                        :key="items.text"
                        :href="items.lank"
                        target="_blank"
                        v-html="items.text"></b-list-group-item>
                    </b-list-group>
                </b-col>
                <!--Sociala medier-->
                <b-col cols="4" md="2" lg="2" order="3" order-md="5" >
                    <div class="float-right float-lg-left">
                        <h2 v-html="content.footer_innehall.sociala_medier.rubrik" />
                        <b-list-group flush>
                            <b-list-group-item 
                            v-for="items in content.footer_innehall.sociala_medier.innehall" 
                            :key="items.ikon.ID"
                            :href="items.lank"
                            target="_blank">
                                <div class="footer-icon"><img :src="items.ikon.url" :alt="items.ikon.alt" /></div>
                            </b-list-group-item>
                        </b-list-group>
                    </div>
                </b-col>
                <!-- Till toppen-knapp -->
                <b-col class="toTopBox mb-4 mb-lg-0" cols="6" lg="1" order-lg="6" order="7">
                    <ToTopButton class="float-right"></ToTopButton>
                </b-col>

                <!-- Copyright -->
                <b-col cols="6" lg="12" order-lg="7" order="6" class="copyright mb-2 align-self-end">
                    <p class="text-lg-center">Copyright {{ year }} 
                        <template v-if="siteData">{{ siteData.name }}</template>
                    </p>
                </b-col>
            </b-row>
        </b-container>
    </footer>
</template>

<script>
import ToTopButton from '@/components/base/ToTopButton'

export default {
    components: {
        ToTopButton
    },
    data() {
        return {
            year: new Date().getFullYear()
        }
    },
    computed: {
        content() {
            return this.$store.state.footer.footerContent.content;
        },
        links() {
            return this.$store.state.footer.footerContent.links;
        },
        siteData() {
            return this.$store.state.footer.footerContent.siteData;
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '~/assets/scss/abstracts/_variables.scss';

    footer {
    background-color: $gallo-dark;
    padding-top: 40px;
    color: white;
    position: relative;
    bottom: 0;
    .row {
        width: 95%;
        max-width: 1200px;
        margin: 0 auto;
    }
    h2 {
        font-size: 14px;
        margin-bottom: 10px;
    }
    .list-group {
        font-size: 1.2rem;
        .list-group-item {
            padding: 0;
            margin-bottom: 5px;
            border: none;
            background-color: $gallo-dark;
            color: white;
        }
        .list-group-item:hover,
        .list-group-item:focus {
            color: $gallo-secondary;
        }
    }
    .logoBox {
        margin-bottom: 40px;
        img {
            width: 150px;
            height: auto;
        }
    }
    .footer-icon {
        background-color: white;
        width: 30px;
        height: 30px;
        padding: 5px;
        border-radius: 5px;
        img {
            width: 100%;
            height: auto;
        }
    }
    .footer-icon:hover,
    .list-group-item:focus .footer-icon {
        background-color: $gallo-secondary;
    }
    .toTopBox {
        padding-left: 0;
    }
    .copyright {
        p {
            font-size: 1rem;
            margin-top: 20px;
        }
    }
}
</style>


