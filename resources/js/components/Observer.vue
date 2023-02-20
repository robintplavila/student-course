<template>
  <div class="observer"></div>
</template>

<script>
export default {
  name: 'observer',
  props: ['filters'],
  emits: ['set-filters'],
  setup(props, context){

    const search = (s) => {
      context.emit('set-filters', {
          ...props.filters,
          s
      })
    }

    const sort = (sort1) => {
      context.emit('set-filters', {
        ...props.filters,
        sort1
      })
    }

    return {
      search,
      sort
    }
  },
  data() {
    return {
      observer: null
    };
  },
  mounted() {
    this.observer = new IntersectionObserver(([entry]) => {
      if(entry && entry.isIntersecting){
        this.$emit('intersect');
      }
    });

    this.observer.observe(this.$el);
  }
}
</script>

<style scoped>
  .observer {
    height: 1px;
  }
</style>