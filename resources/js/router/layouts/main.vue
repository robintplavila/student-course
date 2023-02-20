<script>
import Topbar from "../../components/topbar";
import MainMenu from "../../components/menu";
import Footer from "../../components/footer";
import Sidebar from "../../components/sidebar";

export default {
  components: { Topbar, MainMenu, Footer,Sidebar },
      setup() {       
        let baseurl = process.env.MIX_BASE_URL        

        return {          
          baseurl
        };
      },
      data(){
        return {
            company: localStorage.getItem("company"),
            company_name: localStorage.getItem("company_name"),
            logo: localStorage.getItem("logo"),
            baseurl : process.env.MIX_BASE_URL ,
            company_path:'storage/companies/',
            role_key: localStorage.getItem("role_key")           
        }
    }
    };
    $(document).on('click', '.side-nav-link', function () {
              $("body").removeClass('end-bar-enabled');
                });

</script>

<template>
  <div class="wrapper">
    <Sidebar/>
    <div class="content-page">
      <div class="content">
        <div class="navbar-custom">
          <Topbar />
          <button class="button-menu-mobile open-left disable-btn">
              <em class="mdi mdi-menu"></em>
          </button>
        </div>
        <div class="container-fluid mb-60">
          <slot />
        </div>
      </div>
      <Footer />
    </div>
  </div>
  <!-- Right Sidebar -->
        <div class="end-bar">

            <div class="rightbar-title">
                <a href="javascript:void(0);" class="end-bar-toggle float-end">
                    <em class="dripicons-cross noti-icon"></em>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <div class="rightbar-content h-100" data-simplebar>

                <div class="p-3">
                    <!-- Settings -->                                     
                    <ul class="right-side-nav">  
                      <li class="side-nav-item">
                          <router-link tag="a" to="/roles" class="side-nav-link">
                              <em class="uil-user-circle"></em>
                              <span> {{ $t("menu.User Role") }}</span>
                          </router-link>
                      </li>
                      <li class="side-nav-item">
                          <router-link tag="a" to="/users" class="side-nav-link">
                              <em class="uil-users-alt"></em>
                              <span> {{ $t("menu.Users") }}</span>
                          </router-link>
                      </li>
                      
                    </ul>                   
                   
                   
                </div> <!-- end padding-->

            </div>
        </div>

        <div class="rightbar-overlay"></div>
        <!-- /End-bar -->
</template>
