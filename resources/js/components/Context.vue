<template>
    <li class="mr-2">
        <button
            class="dim"
            v-bind:class="{ 'font-bold': isCurrent }"
            v-on:click="setCurrentContext"
        >
            {{ publicName }}
        </button>
    </li>
</template>

<script>
  export default {

    props: [
      'publicName',
      'contextKey',
      'isCurrent',
      'index',
    ],

    methods: {
      setCurrentContext() {
        if (!this.isCurrent) {
          this.$emit('selected-context', [this.index, this.contextKey]);
        }
      }
    },
  }
</script>

<style scoped>


</style>
