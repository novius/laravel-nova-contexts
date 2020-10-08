<template>
    <li class="mr-2">
        <button
            class="dim"
            v-bind:class="{ active: isCurrent }"
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

<style lang="scss" scoped>
li {

  &:not(:last-child)::after {
    display: inline-block;
    margin-left: .5rem;
    color: #7c858e; // stylelint-disable-line
    content: "|";
  }

  button {
    color: #3c4b5f; // stylelint-disable-line

    &.active {
      color: var(--primary);
      text-decoration: underline;
    }
  }
}
</style>
