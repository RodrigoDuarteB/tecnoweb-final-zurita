import { reactive } from 'vue';

export const loadingState = reactive({
    isVisible: false,
});

export function showLoading() {
  loadingState.isVisible = true;
}

export function hideLoading() {
  loadingState.isVisible = false;
}
