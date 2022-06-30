<template>
  <div :class="`text-${field.textAlign}`">
    <Link
      @click.stop
      v-if="hasValue && resource.authorizedToView"
      :href="$url(`/resources/${resourceName}/${field.value}`)"
      class="link-default"
    >
      {{ field.pivotValue || field.value }}
    </Link>
    <p v-else-if="hasValue">
      {{ field.pivotValue || field.value }}
    </p>
    <p v-else>&mdash;</p>
  </div>
</template>

<script>
export default {
  props: ['resource', 'resourceName', 'field'],

  computed: {
    /**
     * Determine if the field has a value other than null.
     */
    hasValue() {
      return this.field.value !== null
    },
  },
}
</script>
