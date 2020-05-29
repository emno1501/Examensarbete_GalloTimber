export const state = () => ({
    footerContent: {
        content: {},
        links: [],
        siteData: {}
    }
});

export const mutations = {
    setContent(state, content) {
        state.footerContent.content = content;
    },
    setFooterLinks(state, links) {
        state.footerContent.links = links;
    },
    setSiteData(state, data) {
        state.footerContent.siteData = data;
    }
}

export const actions = {
    async getContent({commit}) {
        let content = await this.$axios.$get("http://gallotimber.be/wp-json/gallotimber/v1/settings");
        commit('setContent', content);
    },
    async getFooterLinks({commit}) {
        let footerLinks = await this.$axios.$get("http://gallotimber.be/wp-json/wp/v2/footer_menu");
        commit('setFooterLinks', footerLinks);
    },
    async getSiteData({commit}) {
        let siteData = await this.$axios.$get("http://gallotimber.be/wp-json");
        commit('setSiteData', siteData);
    }
}