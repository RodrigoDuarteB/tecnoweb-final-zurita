<template>
    <select v-model="internalValue"
    @change="updateValue" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option :value="''" :unselectable="true">Seleccione un Item</option>
        <option v-for="(item, index) in items" :key="index" :value="item.value">
            {{ item.label }}
        </option>
    </select>
</template>

<script setup>
    import { computed, toRefs } from "vue";

    // Props
    const props = defineProps(['modelValue', 'items']);

    // Emits
    const emit = defineEmits(["update:modelValue"]);

    // Computed property for v-model
    const { modelValue } = toRefs(props);
    const internalValue = computed({
        get: () => modelValue.value,
        set: (newValue) => emit("update:modelValue", newValue),
    });

    // Methods
    const updateValue = (event) => {
        internalValue.value = event.target.value;
    };
</script>

<style lang="scss" scoped>

</style>
