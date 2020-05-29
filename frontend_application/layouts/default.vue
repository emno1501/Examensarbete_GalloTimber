<template>
  <div>
    <Header></Header>
      <nuxt />
    <Footer></Footer>
  </div>
</template>

<script>
import Header from '@/components/Header'
import Footer from '@/components/Footer'

import axios from 'axios'

export default {
  components: {
      Header,
      Footer
  },
  data() {
    return {
        menuData: [],
        menuData2: [],
        footerMenu: [],
        footerContent: [],
        siteData: null,
        logo: null
    }
  },
  async asyncData({params}) {
    let menuData = [];
    let menuData2 = [];
    let footerMenu = [];
    let footerContent = [];
    let siteData = null;
    let logo = null;

    if (process.server) {
        let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/nav_menu")
        menuData = data;
    }
    if (process.server) {
        let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/nav_menu2")
        menuData2 = data;
    }
    if (process.server) {
        let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/footer_menu")
        footerMenu = data;
    }
    if (process.server) {
        let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=footer")
        footerContent = data;
    }
    if (process.server) {
        let {data} = await axios.get("http://gallotimber.be/wp-json")
        siteData = data;
    }
    if (process.server) {
        let {data} = await axios.get("http://gallotimber.be/wp-json/gallotimber/v1/settings")
        logo = data;
    }
    return {
        menuData,
        menuData2,
        footerMenu,
        footerContent,
        siteData,
        logo
    }
  },
  async mounted() {
    if (this.menuData.length == 0) {
            let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/nav_menu")
            this.menuData = data;
    }
    if (this.menuData2.length == 0) {
            let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/nav_menu2")
            this.menuData2 = data;
    }
    if (this.footerMenu.length == 0) {
            let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/footer_menu")
            this.footerMenu = data;
    }
    if (this.footerContent.length == 0) {
            let {data} = await axios.get("http://gallotimber.be/wp-json/wp/v2/pages?slug=footer")
            this.footerContent = data;
    }
    if (this.siteData == null) {
            let {data} = await axios.get("http://gallotimber.be/wp-json")
            this.siteData = data;
    }
    if (this.logo == null) {
            let {data} = await axios.get("http://gallotimber.be/wp-json/gallotimber/v1/settings")
            this.logo = data;
    }
  }
}
</script>