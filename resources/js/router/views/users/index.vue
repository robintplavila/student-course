<script>
import appConfig from "../../../app.config";
import Layout from "../../layouts/main";
import PageHeader from "../../../components/page-header";
import FullLoader from "../../../components/full-loader";
/**
 * Products component
 */
export default {
  page: {
    title: "System Admin",
    meta: [{ name: "description", content: appConfig.description }],
  },
  components: {
    Layout,
    PageHeader,
    FullLoader
  },
  data() {
    return {
      users: {},
      token: localStorage.getItem("token"),
      page: 1,      
      useremail:localStorage.getItem('uemail'),
      searchTerm: '',
      title: this.$t("users.Users"),
      role_key : 'super_admin',
      columns: [{
        label: ""
      }, {
        label: this.$t("users.First Name"),
        key: "first_name",
        sortable: true
      }, {
        label: this.$t("users.Family Name"),
        key: "family_name",
        sortable: true
      }, {
        label: this.$t("users.Date of Birth"),
        key: "date_of_birth",
        //sortable: true
      }, {
        label: this.$t("users.E-mail address"),
        key: "email",
       // sortable: true
      }],
      sortKey: "",
      sortOrder: "asc"     
    };
  },  
  methods: {
    sortHandler(key) {
     
      if (key === this.sortKey) {        
        this.sortOrder = this.sortOrder === "desc" ? "asc" : "desc";
      } else {
        this.sortKey = key;
      }
      this.getResults();
    },    
    getResults(page = 1) {
      axios
        .get("user", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token,
          },
          params: {
            page,
            query: this.searchTerm,
            sort_key: this.sortKey,
            sort_order: this.sortOrder,
            role_key:this.role_key            
          },
        })
        .then((response) => {
          this.users = response.data.data;
          this.show=false
        });
      this.page = page + 1;
    },
    deleteUser(id) {
      Swal.fire({
        text: this.$t("Are you sure you want to delete this?"),
        showCancelButton: true,
        confirmButtonColor: "#548235",
        cancelButtonColor: "#545b62",
        confirmButtonText: this.$t("Yes, delete it!"),
      }).then((result) => {
        // Send request to the server        
        if (result.value) {
          axios
            .delete("user/" + id, {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: "Bearer " + this.token,
                },
            })
            .then(() => {
              Toast.fire({
                icon: "success",
                title: this.$t("users.User has been Deleted"),
              });
              this.getResults();
            })
            .catch((data) => {
              Toast.fire({
                icon: "error",
                title: this.$t("Some error occured! Please try again"),
              });
            });
        }
      });
    },
    resetSearch(){      
      this.searchTerm=''
      this.getResults()
    },    
  },  
  mounted() {             
    this.getResults();
  },
};
</script>

<template>
  <Layout>
    <FullLoader :show="show" />
    <PageHeader :title="title" />
    <div class="row">
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body">
            <div class="row mb-2 serach_txt_group">
                <div class="col-sm-3 mb-2">
                  <label
                    ><input
                      type="search"
                      v-model="searchTerm"
                      class="form-control form-control-sm"
                      :placeholder="$t('Search...')"
                      aria-controls="products-datatable"
                  /></label>
                </div>
                <div class="col-sm-3">
                  <div class="text-sm-left">
                    <button
                      type="button"
                      @click="getResults"
                      class="btn btn-light mb-2 btn-sm"
                    >
                      <em class="mdi mdi-magnify"></em>
                    </button>
                    <button
                      type="button"
                      @click="resetSearch"
                      class="btn btn-light mb-2 ms-2 btn-sm"
                    >
                      <em class="mdi mdi-reload"></em>
                    </button>
                  </div>
                </div>
              <div class="col-sm-6">
                <div class="text-sm-end">
                  <router-link
                    to="/new-user"
                    class="btn btn-light mb-2 me-1 btn-sm"
                    tag="button"
                    ><em class="mdi mdi-plus-thick"></em
                  ></router-link>
                </div>
              </div>
            </div>    
            <table aria-label="Users" aria-describedby="gebruikers_table_desc" id="scroll-horizontal-datatable" class="table w-100 nowrap table-sm table-centered">
              <thead>
                <tr> 
                  <th v-for="column in columns" :key="column.label">
                    {{ column.label }}
                    <em class="mdi mdi-sort" 
                    v-if="column.sortable" 
                    @click="sortHandler(column.key)"></em> 
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="index">                  
                  <td>
                    <a
                      v-show="user.role_key !== 'super_admin'"
                      class="action-icon"
                      @click="deleteUser(user.user_id)"
                    >
                      <em class="mdi mdi-close-thick"></em>
                    </a>
                    <router-link
                      :to="{
                        name: 'edit-user',
                        params: { id: user.user_id },
                      }"
                      class="action-icon"
                      ><em class="mdi mdi-square-edit-outline"></em
                    ></router-link>
                  </td>
                  <td class="text-capitalize">{{ user.first_name }}</td> 
                  <td class="text-capitalize">{{ user.family_name }}</td> 
                  <td>{{ user.date_of_birth }}</td>                   
                  <td>{{ user.email }}</td>                            
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
  </Layout>
</template>
<style>
#newuser {
  padding: 36px !important;
}
.modal-open div.text-sm-right button.btn.btn-primary {
  pointer-events: none;
}
.form-control.is-invalid,
.was-validated .form-control:invalid {
  background-image: none;
}
</style>