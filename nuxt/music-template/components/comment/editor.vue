<template>
    <div>
      <textarea id="editor" v-model="textareaData"></textarea>
    </div>
  </template>
  
  <script setup>
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  
  const props = defineProps({
    modelValue: String,
  });
  
  const emit = defineEmits(['update:modelValue']);
  const textareaData = ref(props.modelValue);

  watch(() => props.modelValue, (newValue) => {
    if (newValue !== textareaData.value) {
      textareaData.value = newValue;
    }
  });
  
  const editorConfig = {
    toolbar: [
      'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'
    ],
  };
  
  onMounted(() => {
    ClassicEditor
      .create(document.querySelector('#editor'), editorConfig)
      .then(editor => {
        editor.model.document.on('change:data', () => {
          textareaData.value = editor.getData();
          emit('update:modelValue', textareaData.value);
        });
      })
      .catch(error => {
        console.error(error);
      });
  });
  
  </script>
  
  <style scoped>
  /* Bạn có thể thêm các style tùy chỉnh cho CKEditor ở đây */
  </style>
  