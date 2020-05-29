<template>
    <header id="header">
        <b-navbar toggleable="lg" type="dark">
            <div class="mainNavBox">
                <a href="#top" class="skipLink">Hoppa över huvudmeny</a>
                <!-- Logotyp -->
                <div class="logoContainer">
                    <b-navbar-brand to="/">
                        <img 
                        v-if="logo"
                        :src="logo.logotyp.url" 
                        :alt="logo.logotyp.alt" />
                    </b-navbar-brand>
                </div>

                <!-- Huvudmeny -->
                <b-navbar-toggle target="navbar-toggle-collapse" v-on:click="menuClosed = !menuClosed">
                    <img v-if="!menuClosed" src="@/static/images/close_white.svg" alt="Stäng meny" class="menuClosed"/>
                    <img v-else src="@/static/images/menu_white.svg" alt="Meny"/>
                </b-navbar-toggle>
                
                <b-collapse id="navbar-toggle-collapse" is-nav>
                    <b-navbar-nav class="ml-auto mainNav" v-if="menu.length > 0">
                        <b-nav-item to="/" >Start</b-nav-item>
                        <b-nav-item 
                        v-for="menuItem in menu"
                        v-bind:key="menuItem.ID"
                        v-bind:to="'/' + menuItem.slug"
                        >
                            <span v-html="menuItem.title"/>
                        </b-nav-item>
                    </b-navbar-nav>

                    <!-- Övre menylist -->
                    <div class="header-utilities">
                        <b-navbar-nav class="ml-auto navbar-light">
                            <b-nav-item 
                            v-for="menuItem in utilities"
                            v-bind:key="menuItem.ID"
                            v-bind:to="'/' + menuItem.slug"
                            
                            >
                                <span v-html="menuItem.title"/>
                            </b-nav-item>
                        </b-navbar-nav>
                    </div>
                </b-collapse>

                <!-- Sökfunktion -->
                <div class="search">
                    <b-button v-on:click="showSearch" class="search-button" >
                        <img v-if="closed" src="@/static/images/search_white.svg" alt="Sök" />
                        <img v-else src="@/static/images/close_white.svg" alt="Stäng sökning" />
                    </b-button>
                    <div class="search-collapse" v-show="!closed">
                        <div>
                            <ul>
                                <b-nav-form v-on:submit="search" role="search">
                                    <b-form-input 
                                    v-bind:placeholder="searchPlaceholder"
                                    v-model="searchString"
                                    id="searchInput"
                                    ></b-form-input>
                                    <b-button 
                                    type="submit"
                                    >
                                        <img src="@/static/images/search_white.svg" alt="Kör sökning" />
                                    </b-button>
                                </b-nav-form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </b-navbar>
    </header>
</template>

<script>
export default {

    data() {
        return {
            closed: true,
            searchPlaceholder: "Vad söker du efter?",
            searchString: "",
            menuClosed: true
        }
    },
    computed: {
        logo() {
            return this.$store.state.header.headerContent.logo;
        },
        menu() {
            return this.$store.state.header.headerContent.menu;
        },
        utilities() {
            return this.$store.state.header.headerContent.utilities;
        }
    },
    methods: {
        showSearch: function() {
            this.closed = !this.closed;
            if (!this.closed) {
                setTimeout(function() {
                    document.getElementById("searchInput").focus();
                }, 2)
            }
        },
        search: function(evt) {
            evt.preventDefault();
            let param = this.searchString;
            this.closed = true;
            this.$router.push( "/search/" + param );
        }
    },
    watch: {
        $route(to, from) {
            this.closed = true;
            this.searchString = "";
            this.menuClosed = true;
        },
        closed() {
            if (!this.closed && !this.menuClosed) {
                this.$root.$emit('bv::toggle::collapse', 'navbar-toggle-collapse')
                this.menuClosed = true;
            }
        },
        menuClosed() {
            if (!this.closed && !this.menuClosed) {
                this.closed = true;
            }
        }
    }
}

</script>

<style lang="scss" scoped>
    @import '~/assets/scss/abstracts/_variables.scss';
    @import '~/assets/scss/abstracts/_mixins.scss';

    header {
        position: fixed;
        width: 100%;
        padding: 0;
        z-index: 10;
        
    }
    .skipLink {
        position: absolute;
        top: 7px;
        left: 35px;
        z-index: 10;
        font-weight: bold;
        color: $gallo-primary;
        @include mediaQueries-md {
            visibility: hidden;
        }
    }
    .skipLink:focus {
        color: black;
    }

    // Utility strip
    .header-utilities {
        position: absolute;
        top: 0;
        right: 0;
        background-color: $gallo-primary;
        width: 100%;
        padding: 5px 0;

        @include mediaQueries-md {
            position: static;
            background-color: $gallo-dark;
            padding: 62px 0 40px 0;
            .navbar-nav {
                float: none;
                padding: 20px 0 0 20px;
                border-top: 1px solid white;
            }
            .nav-link {
                color: white !important;
                font-size: 1.6rem;
            }
        }

        ul {
            margin-right: 20px;
            @include mediaQueries-md {
                margin-right: 0;
            }
        }
        .navbar-nav {
            float: right;
        }
        .nav-link {
            color: black !important;
            font-size: 1.4rem;
        }
        .nav-link:hover {
            color: white !important;
        }
        
    }

    // Main navigation
    .navbar {
        padding: 0;
        .mainNavBox {
            padding-top: 57px;
            width: 100%;

            @include mediaQueries-md {
                padding-top: 10px;
            }
        }
        .logoContainer {
            @include mediaQueries-md {
                position: relative;
                width: 180px;
                margin: 0 auto;
                top: -3px;
                z-index: 10;
            }
            @include mediaQueries-sm {
                width: 150px;
                top: 0;
            }
        }
        .navbar-brand {
            float: left;
            position: relative;
            z-index: 5;
            margin-left: 35px;
            margin-bottom: 12px;
            img {
                width: 200px;
                height: auto;
            }
            
            @include mediaQueries-md {
                float: none;
                position: absolute;
                margin: 0;
                img {
                width: 180px;
                }
            }
            @include mediaQueries-sm {
                img {
                    width: 150px;
                }
            }
        }
        .mainNav {
            float: right;
            position: relative;
            right: 77px;
            z-index: 5;
            top: 12px;
            .nav-link {
                font-size: 1.6rem;
            }
            .nav-link:hover {
                color: $gallo-primary;
            }
            .nav-link:focus {
                color: white;
            }
            @include mediaQueries-md {
                float: none;
                position: static;
                margin: -77px;
                padding: 85px 0 30px 20px;
                background-color: $gallo-dark;
            }
        }
        .nav-link {
            font-family: $headings-font-family;
            font-weight: $headings-font-weight;
            letter-spacing: 0.02em;

        }
        .navbar-toggler {
            position: relative;
            border: none;
            z-index: 5;
            img {
                width: 27px;
                //height: auto;
                height: 18.22px;
            }
            .menuClosed {
                width: 27px;
                height: 27px;
            }
            @include mediaQueries-md {
                padding: 0;
                margin: 13px 0 27px 20px;
            }
            @include mediaQueries-sm {
                padding: 0;
                margin: 13px 0 22px 20px;
            }
        }
    }

    // Searchbox
    .search {
        text-align: right;
        position: relative;
        margin-top: -20px;
        z-index: 4;

        @include mediaQueries-md {
            position: absolute;
            right: 0;
            left: 0;
            top: 33px;
        }

        button {
            background-color: rgba(0, 0, 0, 0);
            border: none;
            padding: 0;
            box-shadow: none;
        }
        img {
            width: 25px;
            height: 25px;
        }
        .search-button img {
            margin-right: 35px;
            @include mediaQueries-md {
                margin-right: 20px;
                margin-top: 8px;
            }
        }
        .search-button:focus img {
            outline: -webkit-focus-ring-color auto 1px;
        }
        .search-collapse {
            background-color: $gallo-primary;
            margin-top: 33px;
            padding: 20px 0;
            position: relative;
            @include mediaQueries-md {
                margin-top: 22px;
            }
            ul {
                margin: 0 auto;
                padding: 0;
                width: 750px;
                max-width: 90%;
                @include mediaQueries-md {
                    width: 450px;
                    max-width: 98%;
                }
            }
            form {
                width: 100%;
                position: relative;
                input {
                    width: 94%;
                    border: none;
                    border-radius: 5px 0 0 5px;
                    height: 44px;
                    padding-left: 15px;
                    background-color: #ebebeb;
                    box-shadow: inset 5px 5px 5px #bababa, 
                                inset -5px -5px 5px #ffffff;
                    @include mediaQueries-md {
                        width: 90%;
                    }
                }
                button {
                    width: 6%;
                    background-color: $gallo-secondary;
                    padding: 9px 0;
                    border-radius: 0 5px 5px 0;
                    @include mediaQueries-md {
                        width: 10%;
                    }
                }
                button:focus,
                button:active {
                    background-color: $gallo-secondary !important;
                    box-shadow: inset 3px 3px 5px #a76500, 
                                inset -3px -3px 5px #ffb100 !important;
                }
                button:focus img {
                    width: 23px;
                    height: 23px;
                }
            }
        }
    }
</style>

