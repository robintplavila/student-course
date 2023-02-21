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
    title: "Dashboard",
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
      title: "Dashboard",      
      getCourseCount:'',
      getStudentCount: '',
      getResultCount:''
    };
  },  
  methods: {
    getCourse() {
      axios
        .get("getCourseCount", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token
          },
        })
        .then((response) => {
          this.getCourseCount = response.data;
        });
    },  
    getStudent() {
      axios
        .get("getStudentCount", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token
          },
        })
        .then((response) => {
          this.getStudentCount = response.data;
        });
    },
    getResult() {
      axios
        .get("getResultCount", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token
          },
        })
        .then((response) => {
          this.getResultCount = response.data;
        });
    },
    
  },  
  mounted() {             
    this.getCourse() 
    this.getStudent()   
    this.getResult()
  },
};
</script>

<template>
  <Layout>
    <!-- <FullLoader :show="show" /> -->
    <PageHeader :title="title" />
    <div class="row">
      <div class="col-xl-9 col-lg-9">

        <div class="row">
            <div class="col-sm-4">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-multiple widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Students</h5>
                        <h3 class="mt-3 mb-3">{{ getStudentCount }}</h3>                        
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-sm-4">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-layer-group widget-icon bg-success-lighten text-success"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Courses</h5>
                        <h3 class="mt-3 mb-3">{{ getCourseCount }}</h3>                        
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col-sm-4">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil uil-tachometer-fast widget-icon bg-success-lighten text-success"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Results</h5>
                        <h3 class="mt-3 mb-3">{{ getResultCount }}</h3>                        
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row -->
        

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