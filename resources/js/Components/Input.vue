<template>
  <div class="flex items-center gap-2 bg-gray-100 p-3 rounded-2xl w-full">
    <slot name="icon" />
    <input
      :placeholder="placeholder"
      :type="type"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="outline-none"
    />
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  placeholder: {
    type: String,
    default: 'Escribe aquí...',
  },
  type: {
    type: String,
    default: 'text',
  },
  modelValue: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['update:modelValue']);
</script>
