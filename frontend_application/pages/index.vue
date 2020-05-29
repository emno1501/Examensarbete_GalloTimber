<template>
    <b-container 
    class="startContainer" 
    fluid 
    id="top"
    role="main">
        <b-row class="startHeader" role="banner"> <!--Start headerbild med hero-->
            <b-col>
                <div class="headerImageContainer">
                    <img 
                    v-if="headerImage"
                    :src="headerImage.url" 
                    alt="" />
                </div>
                <div class="imageCover"></div>
                <template v-if="pageData">
                    <h1 v-if="pageData.hero" v-html="pageData.hero"/>
                </template>
            </b-col>
        </b-row>
         <!--Om oss-fakta-->
        <template v-if="pageData && aboutData.length > 0 && prodData.length > 0 && susData.length > 0 && contactData.length > 0">
        <b-row class="startAbout" align-h="center" v-if="pageData.company_facts">
            <b-col
            v-for="fact in pageData.company_facts.fact"
            :key="fact.rubrik"
            class="factBox mb-5"
            cols="6" md="4" lg="2">
                <NeuFrameInset><img :src="fact.ikon.url" alt="" /></NeuFrameInset>
                <h2 v-html="fact.rubrik"/>
                <p v-html="fact.text"/>
            </b-col>
            <b-col cols="12" class="buttonContainer">
                <PrimaryButton :route="aboutData[0].slug">Mer om oss</PrimaryButton>
            </b-col>
        </b-row>

        <b-row class="startInfo" > 
            <!--Kort om produkter-->
            <b-col cols="12" lg="6" class="infoContainer">
                <div class="backgroundImage">
                    <img 
                    v-if="pageData.products.background" 
                    :src="pageData.products.background.url" 
                    alt="" />
                </div>
                <div class="imageCover"></div>
                <div class="startInfoText">
                    <h2 v-if="pageData.products.title" v-html="pageData.products.title"/>
                    <p v-if="pageData.products.content" v-html="pageData.products.content"/>
                    <PrimaryButton 
                    :route="prodData[0].slug">
                        Mer om <span v-html="prodData[0].title.rendered.toLowerCase()" />
                    </PrimaryButton>
                </div>
            </b-col>
            <!--Kort om hållbarhet-->
            <b-col cols="12" lg="6" class="infoContainer"> 
                <div class="backgroundImage">
                    <img 
                    v-if="pageData.sustainability.background" 
                    :src="pageData.sustainability.background.url" 
                    alt="" />
                </div>
                <div class="imageCover"></div>
                <div class="startInfoText">
                    <h2 v-if="pageData.sustainability.title" v-html="pageData.sustainability.title"/>
                    <p v-if="pageData.sustainability.content" v-html="pageData.sustainability.content"/>
                    <PrimaryButton :route="susData[0].slug">Mer om <span v-html="susData[0].title.rendered.toLowerCase()"/></PrimaryButton>
                </div>
            </b-col>
        </b-row>

        <b-row class="startContact"> <!--Kontaktsektion-->
            <b-col>
                <h2>Kontakta oss</h2>
                <b-row v-if="contactData.length > 0"> <!--Kontaktinfo-->
                <template v-if="contactData[0].employees">
                    <b-col
                    class="contactPerson"
                    cols="12" md="9">
                        <b-row class="my-0 text-center text-md-left">
                            <b-col cols="12" md="auto" class="px-0 mb-3 mb-md-0 mr-md-4">
                                <img :src="contactPerson.profilbild.url" :alt="contactPerson.namn" />
                            </b-col>
                            <b-col cols="12" md="auto" class="px-0">
                                <h3><span>{{ contactPerson.foretagsroll }}</span><br/>{{ contactPerson.namn }}</h3>
                                <b-link :href="'mailto:' + contactPerson.epost" target="_blank">
                                    <p v-html="contactPerson.epost"/>
                                </b-link>
                                <b-link :href="'tel:' + contactPerson.phonelink" target="_blank">
                                    <p v-html="contactPerson.telefon"/>
                                </b-link>
                            </b-col>
                        </b-row>
                    </b-col>
                </template>
                <template v-if="contactData[0].contact_meta">
                    <b-col class="generalContact text-center text-md-left" cols="12" md="3">
                        <div class="float-md-right">
                            <h3><span/><br/>{{ contactData[0].contact_meta.epost.titel }} & {{ contactData[0].contact_meta.telefon.titel }}</h3>
                            <b-link :href="'mailto:' + contactData[0].contact_meta.epost.innehall" target="_blank">
                                <p v-html="contactData[0].contact_meta.epost.innehall" />
                            </b-link>
                            <b-link :href="contactData[0].contact_meta.telefon.lank" target="_blank">
                                <p v-html="contactData[0].contact_meta.telefon.innehall" />
                            </b-link>
                        </div>
                    </b-col>
                </template>
                </b-row>
            </b-col>
            <b-col cols="12" class="buttonContainer">
                <PrimaryButton :route="contactData[0].slug">Visa alla kontakter</PrimaryButton>
            </b-col>
        </b-row>
        </template>
        <template v-else>
            <b-row>
                <LoadingSpinner/>
            </b-row>
        </template>
    </b-container>
</template>

<script>
    import axios from 'axios'

    import PrimaryButton from '@/components/base/PrimaryButton'
    import NeuFrameInset from '@/components/base/NeuFrameInset'
    import LoadingSpinner from '@/components/base/LoadingSpinner'

    export default {
        components: {
            PrimaryButton,
            NeuFrameInset,
            LoadingSpinner
        },
        data() {
            return {
                pageData: null,
                contactData: [],
                aboutData: [],
                prodData: [],
                susData: []
            }
        },
        async asyncData() {
            let pageData = null;
            let contactData = [];
            let aboutData = [];
            let prodData = [];
            let susData = [];

            if (process.server) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=startsida")
                pageData = data[0].start_content;
            }
            if (process.server) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=kontakta-oss")
                contactData = data;
            }
            if (process.server) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=om-gallo-timber")
                aboutData = data;
            }
            if (process.server) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=produkter-ravara")
                prodData = data;
            }
            if (process.server) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=hallbarhet-miljo")
                susData = data;
            }

            return {
                pageData,
                contactData,
                aboutData,
                prodData,
                susData
            }
        },
        computed: {
            headerImage() {
                return this.$store.state.header.headerContent.headerImage;
            },
            siteData() {
                return this.$store.state.header.headerContent.siteData;
            },
            contactPerson() {
                let employees = this.contactData[0].employees;
                for (let i = 0; i < employees.length; i++) {
                    if (employees[i].kontaktperson) {
                        employees[i].phonelink = employees[i].telefon.split(" ").join("");
                        return employees[i];
                    }
                }
            }
        },
        methods: {
            // Change main navigation background when scrolling down
            handleScroll: function() {
                var header = document.getElementById('header');
                if (window.pageYOffset > 420) {
                header.style.backgroundColor = 'rgba(0, 0, 0, 0.75)';
                } else {
                header.style.backgroundColor = 'rgba(0, 0, 0, 0)';
                }
            }
        },
        async mounted() {
            if (this.pageData == null) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=startsida");
                this.pageData = data[0].start_content;
            }
            if (this.contactData.length == 0) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=kontakta-oss");
                this.contactData = data;
            }
            if (this.aboutData.length == 0) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=om-gallo-timber");
                this.aboutData = data;
            }
            if (this.prodData.length == 0) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=produkter-ravara");
                this.prodData = data;
            }
            if (this.susData.length == 0) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=hallbarhet-miljo");
                this.susData = data;
            }
            
            window.addEventListener("scroll", this.handleScroll, false);
        },
        head() {
            return {
                title: this.siteData.name + " | Start"
            }
        }
    };
</script>