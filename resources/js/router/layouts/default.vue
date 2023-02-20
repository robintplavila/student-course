<script>
export default {
  components: {},
  created: () => {
    //document.body.classList.add('authentication-bg')
  },
};
</script>

<template>
  <div>
    <div class="auth-fluid">
      <slot />
    </div>
    <!-- end auth-fluid-->
  </div>
</template>
