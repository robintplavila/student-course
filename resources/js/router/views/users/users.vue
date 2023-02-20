<script>
import appConfig from "../../../app.config";
import Layout from "../../layouts/main";
import PageHeader from "../../../components/page-header";
import useVuelidate from "@vuelidate/core";
import {
  required,
  email,
  minLength,  
  helpers,
  requiredIf,
} from "@vuelidate/validators";
import { sub, subYears ,addMonths, getMonth, getYear, subMonths } from 'date-fns';

export default {
  page: {
    title: "Create User",
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
        ? this.$t("users.edit-user")
        : this.$t("users.create-user"),
      form: new Form({
        first_name: "",
        family_name: "",
        email: "",
        date_of_birth: "",
        role_key: 'super_admin'   
      }),
      submitted: false,     
    };
  },
  validations: {
    form: {
      first_name: {
        required: helpers.withMessage("users.First Name is required", required),
      },
      family_name: {
        required: helpers.withMessage("users.Family Name is required", required),
      },
      email: {
        required: helpers.withMessage("users.Email is required", required),
        email: helpers.withMessage("users.Email is invalid", email),
      },
      date_of_birth: {
        required: helpers.withMessage("users.Date of birth is required", required),
      },            
    },
  },
  computed: {
    getEndDate() {
     var endDate = subYears (new Date(), 10);
     return endDate.toISOString().slice(0,10)
    }
  },
  mounted() {
    this.editmode = true;
    if (typeof this.id == "undefined") {
      this.editmode = false;
    }
    this.title=this.editmode
        ? this.$t("users.edit-user")
        : this.$t("users.create-user")
    this.getUserData();
  },
  methods: {
    onClosedate_of_birth() {
      this.form.date_of_birth = "";
    },
    getUserData() {      
      if (this.editmode) {
        axios
          .get("user/" + this.id, {
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
    createUser(e) {
      this.submitted = true;
      // stop here if form is invalid
      this.v$.$touch();
      if (this.v$.$invalid) {
        return;
      }      
      this.isActive = false;
      this.submitted = false;
      this.form
        .post("user", {
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
          this.$router.push({ path: "/users" });
        })
        .catch((errors) => {
          this.isActive = true;          
          if (typeof errors.response.data.errors.email[0] !== "undefined") {
            Toast.fire({
              icon: "error",
              title: this.$t(errors.response.data.errors.email[0]),
            });
            return false;
          } else {
            this.errors = {};
          }
        });
    },
    updateUser(e) {
      this.submitted = true;
      // stop here if form is invalid
      this.v$.$touch();
      if (this.v$.$invalid) {
        return;
      }
      this.isActive = false;
      axios
        .put("user/" + this.id, this.form, {
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
          this.$router.push({ path: "/users" });
        })
        .catch((errors) => {
          this.isActive = true;
          if (typeof errors.response.data.errors.email !== "undefined") {
            Toast.fire({
              icon: "error",
              title: this.$t(errors.response.data.errors.email[0]),
            });
            return false;
          } else {
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
              @submit.prevent="editmode ? updateUser() : createUser()"
            >
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label>{{ $t("users.First Name") }}</label>
                    <em class="mdi mdi-asterisk"></em>
                    <input
                      v-model="form.first_name"
                      type="text"
                      name="first_name"
                      class="form-control"
                      :class="{
                        'is-invalid': submitted && v$.form.first_name.$error,
                      }"
                      autocomplete="false"
                    />
                    <div
                      class="invalid-feedback"
                      v-for="(error, index) of v$.form.first_name.$errors"
                      :key="index"
                      autocomplete="off"
                    >
                      <div class="error-msg">{{ $t(error.$message) }}</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label>{{ $t("users.Family Name") }}</label>
                    <em class="mdi mdi-asterisk"></em>
                    <input
                      v-model="form.family_name"
                      type="text"
                      name="family_name"
                      class="form-control"
                      :class="{
                        'is-invalid': submitted && v$.form.family_name.$error,
                      }"
                      autocomplete="false"
                    />
                    <div
                      class="invalid-feedback"
                      v-for="(error, index) of v$.form.family_name.$errors"
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
                    <label for="email">{{ $t("users.E-mail address") }}</label>
                    <em class="mdi mdi-asterisk"></em>
                    <input
                      type="email"
                      v-model="form.email"
                      id="email"
                      name="email"
                      class="form-control"
                      :class="{
                        'is-invalid': submitted && v$.form.email.$error,
                      }"
                      autocomplete="false"
                    />

                    <div
                      class="invalid-feedback"
                      v-for="(error, index) of v$.form.email.$errors"
                      :key="index"
                      autocomplete="off"
                    >
                      <div class="error-msg">{{ $t(error.$message) }}</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="email">{{ $t("users.Date of Birth") }}</label>
                    <em class="mdi mdi-asterisk"></em>
                    <VueDatePicker
                      v-model="form.date_of_birth"
                      weekNumbers
                      locale="en-CA"
                      format="dd-MM-yyyy"
                      weekNumName="We"
                      :max-date="getEndDate"                      
                      autoApply                     
                      :enableTimePicker="false"
                      :class="{
                        'is-invalid':
                          submitted &&
                          v$.form.date_of_birth.$error,
                      }"
                      @cleared="onClosedate_of_birth"
                    ></VueDatePicker>

                    <div
                      class="invalid-feedback"
                      v-for="(error, index) of v$.form.date_of_birth.$errors"
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
                      to="/users"
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