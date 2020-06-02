<template>
    <b-container class="contentContainer" fluid id="top" role="main">
        <b-row class="contentPageHeader">
            <b-col class="content-header-image"> <!-- Headerbakgrund -->
                <div>
                    <img 
                    v-if="headerImage"
                    :src="headerImage.url" 
                    :alt="headerImage.alt" />
                </div>
                <div class="imageCover"></div>
            </b-col>
        </b-row>
        <b-row>
            <h1>Sökning</h1>
        </b-row>
        <template v-if="pageData.length > 0">
            <b-row class="content"> <!-- Listning av sökresultat -->
                <b-col  
                cols="12"
                v-for="data in pageData"
                :key="data.id">
                    <b-link v-bind:to="'/' + data.slug">
                        <h2 v-html="data.title.rendered"/>
                        <p v-if="data.excerpt" v-html="data.excerpt.rendered"/>
                        <p v-if="data.contact_meta">
                            <span 
                            v-for="content in data.contact_meta"
                            :key="content.titel"
                            v-html="content.titel + ': ' + content.innehall + ', '" />
                            [...]
                        </p>
                    </b-link>
                </b-col>
            </b-row>
        </template>
        <template v-else>
            <b-row class="content">
                <b-col  
                cols="12"> <!-- Box för felmeddelande -->
                    <h2 class="text-center">{{ message }}</h2>
                </b-col>
            </b-row>
        </template>
    </b-container>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            pageData: [],
            message: "Laddar resultat ...",
            jobData: null,
            reversedArray: [],
            testItem: ""
        }
    },
    async asyncData({params}) {
        let pageData = [];
        let message = "";
        let jobData = null;
        let reversedArray = [];
        let testItem = "";

        if (process.server) {
            if (params.search != null ) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/jobs?search=" + encodeURIComponent(params.search.trim()));
                jobData = data;
            }
        }

        if (process.server) {
            
            if (params.search != null ) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?search=" + encodeURIComponent(params.search.trim()));

                pageData = data;
                pageData = pageData.concat(jobData);

                if (pageData.length > 0) {

                    for (let i = 0; i < pageData.length; i++) {
                        if (pageData[i].template == 'template-start.php') {
                            pageData.splice(i, 1);
                        }
                    }
                    if (pageData.length > 0) {
                        return pageData;
                    }  else {
                        message = "Inga sökresultat hittades"
                    }
                } else {
                    message = "Inga sökresultat hittades";
                }
            } else {
                message  = "Inga sökresultat hittades";
            }
            
        }
        return {
            pageData
        }
    },
    computed: {
        headerImage() {
            return this.$store.state.header.headerContent.headerImage;
        },
        siteData() {
            return this.$store.state.header.headerContent.siteData;
        }
    },
    methods: {
        // Change main navigation background when scrolling down
        handleScroll: function(event) {
            var header = document.getElementById('header');
            if (window.pageYOffset > 50) {
            header.style.backgroundColor = 'rgba(0, 0, 0, 0.75)';
            } else {
            header.style.backgroundColor = 'rgba(0, 0, 0, 0)';
            }
        }
    },
    async mounted() {
        if (this.jobData == null) {
            if (this.$route.params.search != null ) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/jobs?search=" + encodeURIComponent(this.$route.params.search.trim()));
                this.jobData = data;
            }
        }

        if (this.pageData.length == 0) {
            if (this.$route.params.search != null) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?search=" + encodeURIComponent(this.$route.params.search.trim()));

                this.pageData = data;
                this.pageData = this.pageData.concat(this.jobData);

                if (this.pageData.length > 0) { // Rensa bort sökresultat från wordpress-sidan med template: template-start.php
                    for (let i = 0; i < this.pageData.length; i++) {
                        if (this.pageData[i].template == 'template-start.php') {
                            this.pageData.splice(i, 1);
                        }
                    }
                    if (this.pageData.length > 0) {
                        // Sätt sökresultaten som innehåller sökordet i titeln först
                        for (let i = this.pageData.length - 1; i > 0; i--) {
                            let title = this.pageData[i].title.rendered.toLowerCase();
                            let searchString = this.$route.params.search.toLowerCase();

                            if (title.includes(searchString)) {
                                let item = this.pageData.splice(i, 1);

                                this.pageData.unshift(item[0]);
                            }
                        }

                        return this.pageData;

                    }  else {
                        this.message = "Inga sökresultat hittades"
                    }
                } else {
                    this.message = "Inga sökresultat hittades"
                }
            } else {
                this.message  = "Inga sökresultat hittades";
            }
        }

        window.addEventListener("scroll", this.handleScroll, false);
    },
    head () {
            return {
                title: this.siteData.name
            }
        }
}
</script>