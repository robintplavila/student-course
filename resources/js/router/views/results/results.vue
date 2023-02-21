<script>
import appConfig from "../../../app.config";
import Layout from "../../layouts/main";
import PageHeader from "../../../components/page-header";
import useVuelidate from "@vuelidate/core";
import {
  required,   
  helpers  
} from "@vuelidate/validators";
import Multiselect from "@vueform/multiselect";
import { scoreData } from "./data";

export default {
  page: {
    title: "New Result",
    meta: [{ name: "description", content: appConfig.description }],
  },
  components: {
    Layout,
    PageHeader,
    Multiselect
  },
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      token: localStorage.getItem("token"),
      editmode: false,
      id: this.$route.params.id,
      isActive: true,
      title: this.editmode
        ? this.$t("results.edit-course")
        : this.$t("results.create-result"),
      form: new Form({
        course_id: "",
        user_id: "",
        score:""        
      }),
      submitted: false,
      getCourseData: [],
      getStudentData: [],
      getScoreData: scoreData.score,
    };
  },
  validations: {
    form: {
      course_id: {
        required: helpers.withMessage("results.Course is required", required),
      },
      user_id: {
        required: helpers.withMessage("results.student is required", required),
      } ,
      score: {
        required: helpers.withMessage("results.score is required", required),
      }               
    },
  },
  created(){
    this.getCourse() 
    this.getStudent()   
  },
  mounted() {
    this.editmode = true;
    if (typeof this.id == "undefined") {
      this.editmode = false;
    }
    this.title=this.editmode
        ? this.$t("results.edit-result")
        : this.$t("results.create-result")
    this.getData();
  },
  methods: {
    getData() {      
      if (this.editmode) {
        axios
          .get("result/" + this.id, {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              Authorization: "Bearer " + this.token,
            },
          })
          .then((response) => {
            this.form = response.data;
          });
      }
    },
    create(e) {
      this.submitted = true;
      // stop here if form is invalid
      this.v$.$touch();
      if (this.v$.$invalid) {
        return;
      }      
      this.isActive = false;
      this.submitted = false;
      this.form
        .post("result", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.isActive = true;
          Toast.fire({
            icon: "success",
            title: this.$t(response.data.message),
          });
          this.$router.push({ path: "/results" });
        })
        .catch((errors) => {
          this.isActive = true;          
          if (typeof errors.response.data.errors.course_name[0] !== "undefined") {
            Toast.fire({
              icon: "error",
              title: this.$t(errors.response.data.errors.course_name[0]),
            });
            return false;
          } else {
            this.errors = {};
          }
        });
    },
    update() {
      this.submitted = true;
      // stop here if form is invalid
      this.v$.$touch();
      if (this.v$.$invalid) {
        return;
      }
      this.isActive = false;
      axios
        .put("result/" + this.id, this.form, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          // success
          this.isActive = true;
          Toast.fire({
            icon: "success",
            title: this.$t(response.data.message),
          });
          this.submitted = false;
          this.$router.push({ path: "/results" });
        })
        .catch((errors) => {
          this.isActive = true;
          if (typeof errors.response.data.errors.course !== "undefined") {
            Toast.fire({
              icon: "error",
              title: this.$t(errors.response.data.errors.course[0]),
            });
            return false;
          } 
          
          else {
            this.errors = {};
          }
        });
    },
    getCourse() {
      axios
        .get("getCourse", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token
          },
        })
        .then((response) => {
          this.getCourseData = response.data;
        });
    },  
    getStudent() {
      axios
        .get("getStudent", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + this.token
          },
        })
        .then((response) => {
          this.getStudentData = response.data;
        });
    },
    
  },
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<template>
  <Layout>
    <PageHeader :title="title" />
    <!-- Start Content-->
    <div class="row">
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body">
            <form
              class="client"
              @submit.prevent="editmode ? update() : create()"
            >
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label>{{ $t("results.Course") }}</label>
                    <em class="mdi mdi-asterisk"></em>
                    <Multiselect                        
                        mode="single"
                        class="form-control"
                        :searchable="true"
                        v-model="form.course_id"
                        :disable="false"
                        :options="getCourseData"                        
                        :noOptionsText="$t('No data available')"
                        :noResultsText="$t('No result found')"
                        :class="{
                          'is-invalid':
                            submitted &&
                            v$.form.course_id.$error,
                        }"
                    />                    
                    <div
                      class="invalid-feedback"
                      v-for="(error, index) of v$.form.course_id.$errors"
                      :key="index"
                      autocomplete="off"
                    >
                      <div class="error-msg">{{ $t(error.$message) }}</div>
                    </div>
                  </div>
                </div> 
                <div class="col-md-6">
                  <div class="mb-3">
                    <label>{{ $t("results.Student") }}</label>
                    <em class="mdi mdi-asterisk"></em>
                    <Multiselect                        
                        mode="single"
                        class="form-control"
                        :searchable="true"
                        v-model="form.user_id"
                        :disable="false"
                        :options="getStudentData"                        
                        :noOptionsText="$t('No data available')"
                        :noResultsText="$t('No result found')"
                        :class="{
                          'is-invalid':
                            submitted &&
                            v$.form.user_id.$error,
                        }"
                    />                    
                    <div
                      class="invalid-feedback"
                      v-for="(error, index) of v$.form.user_id.$errors"
                      :key="index"
                      autocomplete="off"
                    >
                      <div class="error-msg">{{ $t(error.$message) }}</div>
                    </div>
                  </div>
                </div>               
              </div>  
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label>{{ $t("results.Score") }}</label>
                    <em class="mdi mdi-asterisk"></em>
                    <Multiselect                        
                        mode="single"
                        class="form-control"
                        :searchable="true"
                        v-model="form.score"
                        :disable="false"
                        :options="getScoreData"                        
                        :noOptionsText="$t('No data available')"
                        :noResultsText="$t('No result found')"
                        :class="{
                          'is-invalid':
                            submitted &&
                            v$.form.score.$error,
                        }"
                    />                    
                    <div
                      class="invalid-feedback"
                      v-for="(error, index) of v$.form.score.$errors"
                      :key="index"
                      autocomplete="off"
                    >
                      <div class="error-msg">{{ $t(error.$message) }}</div>
                    </div>
                  </div>
                </div>        
              </div>            
              <div class="row">                
                <div class="col-md-12">
                  <div class="text-sm-left">
                    <button
                      class="btn btn-primary me-1 btn-sm"
                      type="submit"
                      :disabled="!isActive"
                      v-show="!editmode"
                    >
                      {{ $t("Save") }}
                    </button>
                    <button
                      v-show="editmode"
                      class="btn btn-primary me-1 btn-sm"
                      type="submit"
                      :disabled="!isActive"
                    >
                      {{ $t("Update") }}
                    </button>
                    <router-link
                      to="/results"
                      class="btn btn-primary btn-sm"
                      tag="button"
                      >{{ $t("Cancel") }}</router-link
                    >
                  </div>
                </div>                
              </div>
            </form>
            <!-- end row -->
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
    </div>
  </Layout>
</template>