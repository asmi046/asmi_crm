<template>
    <div class="editorjs" ref="htmlelement"></div>
</template>

<script setup>
  import EditorJS from '@editorjs/editorjs';
  import EmbedTool from '@editorjs/embed';
  import ListTool from '@editorjs/list';
  import ImageTool from '@editorjs/image';
  import Header from '@editorjs/header';
  import RawTool from '@editorjs/raw';
  import LinkTool from '@editorjs/link';
//   import VideoTool from './editorjs/video.js';
  import { onMounted, onUnmounted, ref, watch } from 'vue';

  const htmlelement = ref(null);

  const props = defineProps(['modelValue', 'placeholder'])
  const emit = defineEmits(['update:modelValue'])


  let editor;
  let updatingModel = false;

  // model -> view
  function modelToView() {
    if (!props.modelValue) { return; }
    if (typeof props.modelValue === 'string') {
      editor.blocks.renderFromHTML(props.modelValue);
      return;
    }

    editor.render(props.modelValue);
  }

  // view -> model
  function viewToModel(api, event) {
    updatingModel = true;

    editor.save().then((outputData) => {
    //   console.log(event, 'Saving completed: ', outputData)
      emit('update:modelValue', outputData);
    }).catch((error) => {
      console.log(event, 'Saving failed: ', error)
    }).finally(() => {
      updatingModel = false;
    })
  }

  onMounted(() => {
    editor = new EditorJS({
      holder: htmlelement.value,
      placeholder: props.placeholder,
      inlineToolbar: ['bold', 'italic', 'link'],
      tools: {
        embed: EmbedTool,
        list: ListTool,
        image: ImageTool,
        header: Header,
        raw: RawTool,
      },
      minHeight: 'auto',
      data: props.modelValue,
      onReady: modelToView,
      onChange: viewToModel,
    })
  })

  watch(() => props.modelValue, () => {
    if (!updatingModel) {
      modelToView()
    }
  })

  onUnmounted(() => {
    editor.destroy()
  })
  </script>
