<script>
import appConfig from "../../../app.config";
import Layout from "../../layouts/main";
import PageHeader from "../../../components/page-header";
import useVuelidate from "@vuelidate/core";
import {
  required,   
  helpers  
} from "@vuelidate/validators";

const pwd_lowercase = helpers.regex(/[a-z]/);
const pwd_uppercase = helpers.regex(/[A-Z]/);
const pwd_number = helpers.regex(/\d/);
const pwd_special = helpers.regex(/[!@#\$%\^\&*\)\(+=._-]/);
const secure_pwd = pwd_lowercase && pwd_uppercase && pwd_number && pwd_special
export default {
  page: {
    title: "New Role",
    meta: [{ name: "description", content: appConfig.description }],
  },
  components: {
    Layout,
    PageHeader,
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
        ? this.$t("user_roles.edit-role")
        : this.$t("user_roles.create-role"),
      form: new Form({
        role_name: ""        
      }),
      submitted: false,
    };
  },
  validations: {
    form: {
      role_name: {
        required: helpers.withMessage("user_roles.Role Name is required", required),
      }            
    },
  },
  mounted() {
    this.editmode = true;
    if (typeof this.id == "undefined") {
      this.editmode = false;
    }
    this.title=this.editmode
        ? this.$t("user_roles.edit-role")
        : this.$t("user_roles.create-role")
    this.getUserData();
  },
  methods: {
    getUserData() {      
      if (this.editmode) {
        axios
          .get("user_role/" + this.id, {
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
        .post("user_role", {
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
          this.$router.push({ path: "/roles" });
        })
        .catch((errors) => {
          this.isActive = true;          
          if (typeof errors.response.data.errors.role_name[0] !== "undefined") {
            Toast.fire({
              icon: "error",
              title: this.$t(errors.response.data.errors.role_name[0]),
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
        .put("user_role/" + this.id, this.form, {
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
          this.$router.push({ path: "/roles" });
        })
        .catch((errors) => {
          this.isActive = true;
          if (typeof errors.response.data.errors.role !== "undefined") {
            Toast.fire({
              icon: "error",
              title: this.$t(errors.response.data.errors.role[0]),
            });
            return false;
          } 
          
          else {
            this.errors = {};
          }
        });
    },
  },
};
</script>

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
                    <label>{{ $t("user_roles.Role Name") }}</label>
                    <em class="mdi mdi-asterisk"></em>
                    <input
                      v-model="form.role_name"
                      type="text"
                      name="first_name"
                      class="form-control"
                      :class="{
                        'is-invalid': submitted && v$.form.role_name.$error,
                      }"
                      autocomplete="false"
                    />
                    <div
                      class="invalid-feedback"
                      v-for="(error, index) of v$.form.role_name.$errors"
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
                      to="/roles"
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