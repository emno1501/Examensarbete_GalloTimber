export const state = () => ({
    headerContent: {
        logo: {},
        menu: [],
        utilities: [],
        headerImage: {},
        siteData: {}
    }
});

export const mutations = {
    setLogo(state, logo) {
        state.headerContent.logo = logo;
    },
    setMenu(state, menu) {
        state.headerContent.menu = menu;
    },
    setUtilities(state, utilities) {
        state.headerContent.utilities = utilities;
    },
    setHeaderImage(state, headerImage) {
        state.headerContent.headerImage = headerImage;
    },
    setSiteData(state, data) {
        state.headerContent.siteData = data;
    }
}

export const actions = {
    async getLogo({commit}) {
        let logoContent = await this.$axios.$get("http://gallotimber.be/wp-json/gallotimber/v1/settings");
        commit('setLogo', logoContent);
    },
    async getMenu({commit}) {
        let menu = await this.$axios.$get("http://gallotimber.be/wp-json/wp/v2/nav_menu");
        commit('setMenu', menu);
    },
    async getUtilities({commit}) {
        let utilities = await this.$axios.$get("http://gallotimber.be/wp-json/wp/v2/nav_menu2");
        commit('setUtilities', utilities);
    },
    async getHeaderImage({commit}) {
        let headerImage = await this.$axios.$get("http://gallotimber.be/wp-json/gallotimber/v1/settings");
        commit('setHeaderImage', headerImage.header_image);
    },
    async getSiteData({commit}) {
        let siteData = await this.$axios.$get("http://gallotimber.be/wp-json");
        commit('setSiteData', siteData);
    }
}