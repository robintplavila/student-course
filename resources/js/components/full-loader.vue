<script>
export default {
  components: {},
  props: {
    show: {
      type: Boolean,
      default: true,
    },
  },
}
</script>

<template>
  <!-- start page loader -->
<div class="full-loader" v-if="show == true">
            <div class="spinner-border avatar-lg text-primary" role="status"></div>
</div> 
  <!-- end page loader -->
</template>
