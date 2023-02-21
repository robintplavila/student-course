<script>
export default {
  props: {
    user: {
      type: Object,
      required: false,
      default: () => ({}),
    },
    layout: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      baseurl : process.env.MIX_BASE_URL,
      token: localStorage.getItem("token"),
      CurrentUser:{},
      username:localStorage.getItem('uname')!='null' && localStorage.getItem('uname')!='undefined' && localStorage.getItem('uname')!=''? localStorage.getItem('uname'):'User',
      useremail:localStorage.getItem('uemail'),
      user_role:localStorage.getItem('role_name') ?localStorage.getItem('role_name') :'admin' ,
      role_key: localStorage.getItem("role_key")
    }
  },
  methods:{
    logout() {
        axios.get('logout', {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => { 
          localStorage.removeItem('token')
          localStorage.removeItem('uname')
          localStorage.removeItem('uemail')         
          localStorage.clear();     
          Toast.fire({
              icon: "success",
              title: this.$t(response.data.message),
          });
          this.$router.push('/login')
        }).catch((errors) => {
           localStorage.removeItem('token')
          localStorage.removeItem('uname')
          localStorage.removeItem('uemail')         
          localStorage.clear();     
          this.$router.push('/login')
        });
    }      
  },

}
</script>

<template>
  <div>
    <ul class="list-unstyled topbar-menu float-end mb-0"> 
        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle arrow-none" href="#" role="button">
                <img :src="baseurl + 'assets/images/flags/uk.jpg'" alt="user-image" class="me-0 me-sm-1" height="12"> 
                <span class="align-middle d-none d-sm-inline-block">English</span>
            </a>
            
        </li>
        <li class="notification-list">
            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                <em class="dripicons-gear noti-icon"></em>
            </a>
        </li>   
        <li class="dropdown notification-list mt-1">
            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">                                        
                <span>
                    <span class="account-user-name">{{username}}</span>
                    <span class="account-position">{{ user_role}}</span>
                </span>
                    <em class="mdi mdi-chevron-down profile-down"></em>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">                

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item"  @click="logout()">
                    <em class="mdi mdi-logout me-1"></em>
                    <span>{{$t("menu.Logout")}}</span>
                </a>

            </div>
        </li>

    </ul>

  </div>
</template>

