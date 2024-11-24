<template>
    <div v-if="isVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="w-12 h-12 border-4 border-gray-300 border-t-white rounded-full animate-spin"></div>
    </div>
  </template>

  <script setup>
  defineProps({
    isVisible: {
      type: Boolean,
      default: false, // Default to false if not passed
    },
  });
  </script>
