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
    title: "Results",
    meta: [{ name: "description", content: appConfig.description }],
  },
  components: {
    Layout,
    PageHeader,
    FullLoader
  },
  data() {
    return {
      results: {},
      token: localStorage.getItem("token"),
      page: 1,
      params: {
        sort: "asc",
        sort_field: "id",
      },
      useremail:localStorage.getItem('uemail'),
      searchTerm: '',
      title: this.$t("results.title"),
      columns: [{
        label: ""
      }, {
        label: this.$t("results.Course"),
        key: "course_name",
        //sortable: true
      }, {
        label: this.$t("results.Student"),
        key: "student_name",
       // sortable: true
      }, {
        label: this.$t("results.Score"),
        key: "score",
        //sortable: true
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
        .get("result", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token,
          },
          params: {
            page,
            query: this.searchTerm,
            sort_key: this.sortKey,
            sort_order: this.sortOrder            
          },
        })
        .then((response) => {
          this.results = response.data.data;
          this.show=false
        });
      this.page = page + 1;
    },
    deleteResult(id) {    
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
            .delete("result/" + id, {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: "Bearer " + this.token,
                },
            })
            .then(() => {
              Toast.fire({
                icon: "success",
                title: this.$t("results.Result has been deleted"),
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
                  <Popper hover  
                    :content="$t('Search')" placement="top"> 
                    <button
                      type="button"
                      @click="getResults"
                      class="btn btn-light mb-2 btn-sm"
                    >
                      <em class="mdi mdi-magnify"></em>
                    </button>
                    </popper>
                    <Popper hover  
                    :content="$t('Reset')" placement="top">  
                    <button
                      type="button"
                      @click="resetSearch"
                      class="btn btn-light mb-2 ms-2 btn-sm"
                    >
                      <em class="mdi mdi-reload"></em>
                    </button>
                    </popper>
                  </div>
                </div>
              <div class="col-sm-6">
                <div class="text-sm-end">
                <Popper hover  
                    :content="$t('New Result')" placement="top">
                  <router-link
                    to="/new-result"
                    class="btn btn-light mb-2 me-1 btn-sm"
                    tag="button"
                    ><em class="mdi mdi-plus-thick"></em
                  ></router-link>
                  </popper>
                </div>
              </div>
            </div>    
            <div class="col-md-4">                            
            <table aria-label="Gebruikers" aria-describedby="gebruikers_table_desc" id="scroll-horizontal-datatable" class="table w-100 nowrap table-sm table-centered">
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
                <tr v-for="(result, index) in results" :key="index">                  
                  <td>
                  <Popper hover  
                    :content="$t('Delete')" placement="top">
                    <a                      
                      class="action-icon"
                      @click="deleteResult(result.result_id)"
                    >
                      <em class="mdi mdi-close-thick"></em>
                    </a>
                    </popper>
                    <Popper hover  
                    :content="$t('Modify')" placement="top">
                    <router-link
                      :to="{
                        name: 'edit-result',
                        params: { id: result.result_id },
                      }"
                      class="action-icon"
                      ><em class="mdi mdi-square-edit-outline"></em
                    ></router-link>
                    </popper>
                  </td>
                  <td class="text-capitalize">{{ result.course }}</td> 
                  <td class="text-capitalize">{{ result.student }}</td> 
                  <td>{{ result.score }}</td>                 
                </tr>
              </tbody>
            </table>
            </div>        
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