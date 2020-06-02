<template>
    <b-container 
    class="contentContainer" 
    fluid 
    id="top">
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
        <b-row class="back-btn-container"> <!-- Tillbaka-knapp -->
            <b-col cols="12">
                <SecondaryButton v-on:back="sendBack">Tillbaka</SecondaryButton>
            </b-col>
        </b-row>
        <template v-if="message != ''"> <!-- Bekräftelsemeddelande vid jobbansökning -->
            <p class="confirm-message">{{ message }}</p>
        </template>
        <template v-else>
            <template v-if="jobData">
            <b-row> <!-- Jobbannons-rubrik -->
                <h1 v-if="jobData.title.rendered" v-html="jobData.title.rendered"/>
            </b-row>
            <b-row class="content">
                <b-col cols="12"> <!-- Jobbeskrivning -->
                    <p v-if="jobData.content.rendered" v-html="jobData.content.rendered"/>
                </b-col>
                <b-col cols="12">
                    <h3>Sök tjänsten</h3>
                    <!-- Ansökningsformulär -->
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
                        <ConfirmationModal id="my-modal"> <!-- Pop up för bekräftelse av ansökan -->
                            Bekräfta ansökan av tjänsten: <span v-html="jobData.title.rendered" />
                            <div>
                                <SecondaryButton @back="$bvModal.hide('my-modal')" class="cancel-btn">Avbryt</SecondaryButton>
                                <PrimaryButton route="/jobb/" class="confirm-btn">Ansök</PrimaryButton>
                            </div>
                        </ConfirmationModal>
                    </b-form>
                </b-col>
            </b-row>
            </template>
            <template v-else>
                <b-row class="loading">
                    <LoadingSpinner/>
                </b-row>
            </template>
        </template>
    </b-container>
</template>

<script>
    import axios from 'axios'

    import LoadingSpinner from '@/components/base/LoadingSpinner'
    import NeuTextInput from '@/components/base/NeuTextInput'
    import NeuTextarea from '@/components/base/NeuTextarea'
    import NeuFileInput from '@/components/base/NeuFileInput'
    import PrimaryButton from '@/components/base/PrimaryButton'
    import SecondaryButton from '@/components/base/SecondaryButton'
    import ConfirmationModal from '@/components/base/ConfirmationModal'

    export default {
        components: {
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
                form: {
                email: '',
                name: '',
                text: '',
                file: null
                },
                jsonFormData: '',
                jobData: null,
                message: ''
            }
        },
        async asyncData({params}) {
            let jobData = null;

            if (params.id) {
                
                if (process.server) {
                    let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/jobs/" + params.id)
                    jobData = data;
                }
                return {
                    jobData
                }
            }
        },
        async mounted() {
            if (!this.$route.params.id) {
                this.message = "Tack för din ansökan!";
            } else {
                if (this.jobData == null) {
                    let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/jobs/" + this.$route.params.id)
                    this.jobData = data;
                }
            }

            window.addEventListener("scroll", this.handleScroll, false);
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
            onSubmit(evt) {
                evt.preventDefault();
                this.jsonFormData = JSON.stringify(this.form);
                this.$bvModal.show("my-modal");
            },
            sendBack() {
                this.$router.back();
            },

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
        head () {
            let jobTitle = "";
            if (this.jobData) {
                jobTitle = this.jobData.title.rendered.replace(/&#038;/g, "&");
            }
            return {
                title: this.siteData.name + " | " + jobTitle
            }
        }
    }
</script>