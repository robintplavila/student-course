<script>
import Layout from "../../layouts/main";
import PageHeader from "../../../components/page-header";
export default {
  page: {
    title: "Nieuwe Beheerder",
    meta: [{ name: "description", content: appConfig.description }],
  },
  components: {
    Layout,
    PageHeader,
  },  
  methods: {
    clientInsert() {
      this.isActive = false;
      axios
        .post("client", this.form, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        })
        .then((response) => {
          Toast.fire({
            icon: "success",
            title: this.$t(response.data),
          });
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" />
    <!-- Start Content-->
    <div class="row">
      <div class="col-xl-12">
        <div class="tab-content mt-30">
          <div class="tab-pane show active" id="default-tabs-preview">
            <ul class="nav nav-tabs mb-3">
              <li class="nav-item">
                <a
                  href="#home"
                  data-bs-toggle="tab"
                  aria-expanded="false"
                  class="nav-link active"
                >
                  <em class="mdi mdi-home-variant d-md-none d-block"></em>
                  <span class="d-none d-md-block">{{
                    $t("klanten.Actief")
                  }}</span>
                </a>
              </li>
              <li class="nav-item">
                <a
                  href="#profile"
                  data-bs-toggle="tab"
                  aria-expanded="true"
                  class="nav-link"
                >
                  <em class="mdi mdi-account-circle d-md-none d-block"></em>
                  <span class="d-none d-md-block">{{
                    $t("klanten.Archief")
                  }}</span>
                </a>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane show active" id="home">
                <div class="row">
                  <div class="col-12">
                    <h4 class="header-title mb-2">
                      {{ $t("klanten.create-client") }}
                    </h4>
                    <div class="tab-content">
                      <div
                        class="tab-pane show active"
                        id="input-masks-preview"
                      >
                        <form class="client" @submit.prevent="clientInsert">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="mb-3">
                                <label class="form-label"
                                  >{{ $t("klanten.emailaddress") }}
                                </label>
                                <input
                                  type="email"
                                  name="emailaddress"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Onset")
                                }}</label>
                                <div class="mt-1">
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      id="aanhef1"
                                      name="aanhef"
                                      class="form-check-input"
                                    />
                                    <label
                                      class="form-check-label"
                                      for="aanhef1"
                                      >{{ $t("klanten.Mr.  (Mister )") }}</label
                                    >
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      id="aanhef2"
                                      name="aanhef"
                                      class="form-check-input"
                                    />
                                    <label
                                      class="form-check-label"
                                      for="aanhef2"
                                      >{{ $t("klanten.Ms. (Misses )") }}</label
                                    >
                                  </div>
                                </div>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.First name")
                                }}</label>
                                <input
                                  type="text"
                                  name="voornaam"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Lastname")
                                }}</label>
                                <input
                                  type="text"
                                  name="achternaam"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Customer type")
                                }}</label>
                                <div class="mt-1">
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      id="soortklant1"
                                      name="soortklant"
                                      class="form-check-input"
                                    />
                                    <label
                                      class="form-check-label"
                                      for="soortklant1"
                                      >{{ $t("klanten.Privat") }}</label
                                    >
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      id="soortklant2"
                                      name="soortklant"
                                      class="form-check-input"
                                    />
                                    <label
                                      class="form-check-label"
                                      for="soortklant2"
                                      >{{ $t("klanten.Business") }}</label
                                    >
                                  </div>
                                </div>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Company name")
                                }}</label>
                                <input
                                  type="text"
                                  name="bedrijfsnaam"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.KVK (Chamber of Commerce)")
                                }}</label>
                                <input
                                  type="text"
                                  name="kvk"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Vat number")
                                }}</label>
                                <input
                                  type="text"
                                  name="btw_nummer"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                            </div>
                            <!-- end col -->

                            <div class="col-md-4">
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Streetname")
                                }}</label>
                                <input
                                  type="text"
                                  name="straatnaam"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Housenumber")
                                }}</label>
                                <input
                                  type="text"
                                  name="huisnummer"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Housenumber addition (like 1A)")
                                }}</label>
                                <input
                                  type="text"
                                  name="huisnummer_toevoeiging"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Zipcode")
                                }}</label>
                                <input
                                  type="text"
                                  name="postcode"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.City")
                                }}</label>
                                <input
                                  type="text"
                                  name="plaats"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Country")
                                }}</label>
                                <input
                                  type="text"
                                  name="land"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Phone number")
                                }}</label>
                                <input
                                  type="tel"
                                  name="telefoonnummer"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Emailadress for invoices")
                                }}</label>
                                <input
                                  type="email"
                                  name="email_tbv_facturen"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Emailadress for invoices 2")
                                }}</label>
                                <input
                                  type="email"
                                  name="email_tbv_facturen2"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Payment condition")
                                }}</label>
                                <select
                                  id="betalingsconditie"
                                  name="betalingsconditie"
                                  class="form-select"
                                >
                                  <option>Choose</option>
                                  <option>Option 1</option>
                                  <option>Option 2</option>
                                  <option>Option 3</option>
                                </select>
                              </div>
                              <div class="mb-4">
                                <label class="form-label">{{
                                  $t("klanten.Tax-free")
                                }}</label>
                                <div class="mt-1">
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      id="taxfree1"
                                      name="taxfree"
                                      class="form-check-input"
                                    />
                                    <label
                                      class="form-check-label"
                                      for="taxfree1"
                                      >{{ $t("klanten.Yes") }}</label
                                    >
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      id="taxfree2"
                                      name="taxfree"
                                      class="form-check-input"
                                    />
                                    <label
                                      class="form-check-label"
                                      for="taxfree2"
                                      >{{ $t("klanten.No") }}</label
                                    >
                                  </div>
                                </div>
                              </div>
                              <div class="mb-4">
                                <label class="form-label">{{
                                  $t("klanten.Active")
                                }}</label>
                                <div class="mt-1">
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      id="actief1"
                                      name="actief"
                                      class="form-check-input"
                                    />
                                    <label
                                      class="form-check-label"
                                      for="actief1"
                                      >{{ $t("klanten.Yes") }}</label
                                    >
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      id="actief2"
                                      name="actief"
                                      class="form-check-input"
                                    />
                                    <label
                                      class="form-check-label"
                                      for="actief2"
                                      >{{ $t("klanten.No") }}</label
                                    >
                                  </div>
                                </div>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.debtor number")
                                }}</label>
                                <input
                                  type="text"
                                  name="debiteurnummer"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Search name ???")
                                }}</label>
                                <input
                                  type="text"
                                  name="zoeknaam"
                                  class="form-control"
                                  data-toggle="input-mask"
                                />
                              </div>
                              <div class="mb-3">
                                <label class="form-label">{{
                                  $t("klanten.Remarks")
                                }}</label>
                                <textarea
                                  name="notities"
                                  data-toggle="maxlength"
                                  class="form-control"
                                  maxlength="225"
                                  rows="3"
                                  placeholder="This textarea has a limit of 225 chars."
                                ></textarea>
                              </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-12">
                              <div class="text-sm-end">
                                <button
                                  class="btn btn-primary me-1 btn-sm"
                                  type="submit"
                                >
                                  Save
                                </button>
                                <button
                                  class="btn btn-primary btn-sm"
                                  type="submit"
                                >
                                  Cancel
                                </button>
                              </div>
                            </div>
                            <!-- end col -->
                          </div>
                        </form>
                        <!-- end row -->
                      </div>
                      <!-- end preview-->
                    </div>
                    <!-- end tab-content-->
                  </div>
                  <!-- end col -->
                </div>
                <!-- end row -->
              </div>
              <div class="tab-pane" id="profile">
                <p>
                  Donec pede justo, fringilla vel, aliquet nec, vulputate eget,
                  arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae,
                  justo. Nullam dictum felis eu pede mollis pretium. Integer
                  tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean
                  vulputate eleifend tellus. Aenean leo ligula, porttitor eu,
                  consequat vitae, eleifend ac, enim.
                </p>
                <p class="mb-0">
                  Food truck quinoa dolor sit amet, consectetuer adipiscing
                  elit. Aenean commodo ligula eget dolor. Aenean massa. Cum
                  sociis natoque penatibus et magnis dis parturient montes,
                  nascetur ridiculus mus. Donec quam felis, ultricies nec,
                  pellentesque eu, pretium quis, sem. Nulla consequat massa quis
                  enim.
                </p>
              </div>
            </div>
          </div>
          <!-- end preview-->
        </div>
        <!-- end tab-content-->
      </div>
      <!-- end col -->
    </div>
  </Layout>
</template>