<template>
    <b-container
    class="contentContainer" 
    fluid
    id="top"
    role="main">
        <b-row class="contentPageHeader">
            <b-col class="content-header-image">
                <div>
                    <img 
                    v-if="headerImage"
                    :src="headerImage.url" 
                    :alt="headerImage.alt" />
                </div>
                <div class="imageCover"></div>
            </b-col>
        </b-row>
        <template v-if="pageData.length > 0" >
        <b-row>
            <h1 v-if="pageData[0].title.rendered" v-html="pageData[0].title.rendered"/>
        </b-row>
        <template v-if="pageData[0].template == 'template-contact-us.php'">
            <b-row class="wide-text-content" v-if="pageData[0].contact_meta">
                <b-col class="small-boxes-container tight-md">
                    <div
                    v-for="contact in pageData[0].contact_meta"
                    v-bind:key="contact.titel"
                    class="wide-content-small-boxes">
                        <b-link :href="contact.lank" target="_blank">
                            <NeuFrame class="contact-icon"><img :src="contact.ikon.url" :alt="contact.titel" /></NeuFrame>
                            <h2 v-html="contact.titel"/>
                            <p v-html="contact.innehall"/>
                        </b-link>
                    </div>
                </b-col>
            </b-row>
            <b-row class="wide-text-content dark-background">
                <b-col>
                    <b-row class="small-boxes-container">
                        <b-col 
                        v-for="employee in pageData[0].employees"
                        v-bind:key="employee.namn"
                        xl="3" lg="4" md="6" cols="12"
                        class="wide-content-small-boxes">
                            <div class="picturebox">
                                <img v-bind:src="employee.profilbild.url" v-bind:alt="employee.profilbild.alt" />
                            </div>
                            <h2><span>{{ employee.foretagsroll }}</span><br/>{{ employee.namn }}</h2>
                            <b-link v-bind:href="'mailto:'+ employee.epost">{{ employee.epost }}</b-link>
                            <b-link v-bind:href="'tel:'+ employee.telefon">{{ employee.telefon }}</b-link>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <b-row>
                <iframe :src="pageData[0].google_maps" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" title="Google maps"></iframe>
            </b-row>
        </template>

        <template v-else>
            <b-row v-if="pageData[0].template == 'template-jobs.php'" class="content">
                <p v-if="pageData[0].content.rendered" v-html="pageData[0].content.rendered"/>
                <h2>Lediga tjänster</h2>
                <BigButton
                v-for="job in jobData"
                :key="job.id"
                :route = "'/jobb/' + job.id">
                    <span v-html="job.title.rendered" />
                </BigButton>

                <h2>Skicka en spontanansökan</h2>

                <!-- Formulär -->
                <b-form @submit="onSubmit">
                    <b-form-group id="input-group-1" label="Namn *" label-for="input-1">
                        <NeuTextInput
                        id = "input-1"
                        v-model="form.name"
                        type = "text"
                        name = "name"
                        autoComplete = "name"
                        ></NeuTextInput>
                    </b-form-group>
                    <b-form-group id="input-group-2" label="E-post *" label-for="input-2">
                        <NeuTextInput
                        id = "input-2"
                        v-model="form.email"
                        type = "email"
                        name = "email"
                        autoComplete = "email"></NeuTextInput>
                    </b-form-group>
                    <b-form-group id="input-group-3" label="Telefonnummer *" label-for="input-3">
                        <NeuTextInput
                        id = "input-3"
                        v-model="form.phone"
                        type = "tel"
                        name = "tel"
                        autoComplete = "tel"></NeuTextInput>
                    </b-form-group>
                    <b-form-group id="input-group-4" label="Meddelande:" label-for="input-4">
                        <NeuTextarea
                        id = "input-4"
                        v-model="form.text"></NeuTextarea>
                    </b-form-group>
                    <b-form-group id="input-group-5" label="Ladda upp CV *" label-for="input-5">
                        <NeuFileInput
                        id = "input-5"
                        :formFile = "form"
                        v-model="form.file"></NeuFileInput>
                    </b-form-group>
                    <PrimaryButton 
                    type="submit"
                    class="wide-button">
                        Skicka
                    </PrimaryButton>
                    <ConfirmationModal id="my-modal">
                        Bekräfta genomförande av spontanansökan
                        <div>
                            <SecondaryButton @back="$bvModal.hide('my-modal')" class="cancel-btn">Avbryt</SecondaryButton>
                            <PrimaryButton route="/jobb/" class="confirm-btn">Ansök</PrimaryButton>
                        </div>
                    </ConfirmationModal>
                </b-form>
            </b-row>

            <b-row class="content" v-else>
                <b-col v-if="pageData[0].kort_fakta">
                    <b-row>
                        <h2 v-if="pageData[0].kort_fakta.rubrik" v-html="pageData[0].kort_fakta.rubrik"/>
                        <p v-if="pageData[0].kort_fakta.text" v-html="pageData[0].kort_fakta.text"/>
                        <template v-if="pageData[0].kort_fakta.faktabox">
                            <b-col 
                            v-for="fakta in pageData[0].kort_fakta.faktabox"
                            :key="fakta.stor_text"
                            class="short-fact-box"
                            cols="6" md="3">
                                <p v-html="fakta.stor_text" class="big-fact-text" />
                                <p v-html="fakta.liten_text" />
                            </b-col>
                        </template>
                    </b-row>
                </b-col>
                <p v-if="pageData[0].content.rendered" v-html="pageData[0].content.rendered"/>
            </b-row>
        </template>
        </template>
        <template v-else >
            <b-row class="loading">
                <LoadingSpinner/>
            </b-row>
        </template>
    </b-container>
</template>

<script>
import axios from 'axios'
import NeuFrame from '@/components/base/NeuFrame'
import BigButton from '@/components/base/BigButton'
import LoadingSpinner from '@/components/base/LoadingSpinner'
import NeuTextInput from '@/components/base/NeuTextInput'
import NeuTextarea from '@/components/base/NeuTextarea'
import NeuFileInput from '@/components/base/NeuFileInput'
import PrimaryButton from '@/components/base/PrimaryButton'
import SecondaryButton from '@/components/base/SecondaryButton'
import ConfirmationModal from '@/components/base/ConfirmationModal'

export default {
    components: {
        NeuFrame,
        BigButton,
        LoadingSpinner,
        NeuTextInput,
        NeuTextarea,
        NeuFileInput,
        PrimaryButton,
        SecondaryButton,
        ConfirmationModal
    },
    data() {
        return {
            pageData: [],
            jobData: [],
            form: {
                email: '',
                name: '',
                phone: '',
                text: '',
                file: null
            },
            jsonFormData: ''
        }
    },
    async asyncData({params}) {
        let pageData = [];
        let jobData = [];

        if (process.server) {
            let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=" + params.page)
            pageData = data;
        }
        if (process.server) {
            let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/jobs")
            jobData = data;
        }
        return {
            pageData,
            jobData
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
        },
        onSubmit(evt) {
            evt.preventDefault()
            this.jsonFormData = JSON.stringify(this.form)
            this.$bvModal.show("my-modal");
            
        }
    },
    async mounted() {
        if (this.pageData.length == 0) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=" + this.$route.params.page)
                this.pageData = data;
        }
        if (this.jobData.length == 0) {
                let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/jobs")
                this.jobData = data;
        }

        window.addEventListener("scroll", this.handleScroll, false);
    },
    head() {
        let pageTitle = "";
        if (this.pageData.length > 0) {
            pageTitle = this.pageData[0].title.rendered.replace(/&#038;/g, "&");
        }
        return {
            title: this.siteData.name + " | " + pageTitle
        }
    }
}
</script>