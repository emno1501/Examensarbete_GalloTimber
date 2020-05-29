export const actions = {
    async nuxtServerInit({dispatch}) {
        await dispatch('header/getLogo');
        await dispatch('header/getMenu');
        await dispatch('header/getUtilities');
        await dispatch('header/getHeaderImage');
        await dispatch('header/getSiteData');

        await dispatch('footer/getContent');
        await dispatch('footer/getFooterLinks');
        await dispatch('footer/getSiteData');
    }
}