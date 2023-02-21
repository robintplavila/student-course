<script>
export default {
  data() {
    return {
      company: localStorage.getItem("company"),
      company_name: localStorage.getItem("company_name"),
      logo: localStorage.getItem("logo"),
      small_logo: localStorage.getItem("small_logo"),
      baseurl: process.env.MIX_BASE_URL,
      company_path: "storage/companies/",
      role_key: localStorage.getItem("role_key"),
      bg_leftbar: localStorage.getItem("primary_color")
        ? localStorage.getItem("primary_color")
        : "#323a46",
      router_path: "",
    };
  },
  computed: {
    bgStyles() {
      return {
        "background-color": this.bg_leftbar,
      };
    },
  },
  mounted() {
    this.router_path = "/students";    
  },
};
$(document).on("click", ".button-menu-mobile", function (e) {
  if ($("body").attr("data-leftbar-compact-mode") !== undefined) {
    $("body").removeAttr("data-leftbar-compact-mode");
  } else {
    $("body").attr("data-leftbar-compact-mode", "condensed");
  }
  if ($(window).width() >= 1040) {
    $("body").removeClass("hide-menu");
  }
});
</script>
<template>
  {{ company }}
  <!-- ========== Left Sidebar Start ========== -->
  <div class="leftside-menu" :style="bgStyles">
    <!-- LOGO -->
    <router-link
      tag="a"
      :to="router_path"
      class="logo text-center logo-light"     
    >
      <span class="logo-lg">
        <img
          :src="baseurl + 'assets/images/logo-dark.png'"
          alt=""          
        />
      </span>
      <span class="logo-sm">
        <img
          :src="baseurl + 'assets/images/logo-dark-sm.png'"
          alt=""          
        /> </span
    ></router-link>
    

    <div class="h-100 pt-4" id="leftside-menu-container" data-simplebar>
      <!--- Sidemenu -->
      <ul class="side-nav">
        <li class="side-nav-item">                            
            <router-link class="side-nav-link" tag="a" to="/dashboard"> 
              <i class="uil-home-alt"></i><span>Home</span>
            </router-link>
        </li>
        <li class="side-nav-item">                            
            <router-link class="side-nav-link" tag="a" to="/students"> 
              <i class="mdi mdi-account-multiple"></i><span>Students</span>
            </router-link>
        </li>
        <li class="side-nav-item">                            
            <router-link class="side-nav-link" tag="a" to="/courses"> 
              <i class="uil-layer-group"></i><span>Courses</span>
            </router-link>
        </li>
        <li class="side-nav-item">                            
            <router-link class="side-nav-link" tag="a" to="/results"> 
              <i class="uil uil-tachometer-fast"></i><span>Results</span>
            </router-link>
        </li>
        

        
      </ul>
      <!-- End Sidebar -->

      <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
  </div>
  <!-- Left Sidebar End -->
</template>