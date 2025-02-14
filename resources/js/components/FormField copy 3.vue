<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <textarea
        :id="field.attribute"
        type="text"
        :class="errorClasses"
        :placeholder="field.name"
        v-model="value"
      ></textarea>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  created () {},
  beforeMount () {},
  mounted () {
    this.$nextTick(()=>{
        this.setEditor();
    });
  },
  beforeUpdate () {},
  updated () {},
  beforeUnmount () {
    tinymce.remove("#" + this.field.attribute);
  },
  unmounted () {},


  errorCaptured () {},
  activated () {},
  deactivated () {},
  serverPrefetch () {},


  methods: {
    /*
      * Set the initial, internal value for the field.
    */
    setInitialValue() {
      this.value = this.field.value || ''
    },


    setEditor () {
        const useDarkMode = false ;
        tinymce.init({
          "selector": "#" + this.field.attribute,
          plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
          menubar: 'file edit view insert format tools table help',
          toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
          autosave_ask_before_unload: true,
          autosave_interval: '30s',
          autosave_prefix: '{path}{query}-{id}-',
          autosave_restore_when_empty: false,
          autosave_retention: '2m',
          image_advtab: true,
          importcss_append: true,
          height: 600,
          image_caption: true,
          quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
          noneditable_class: 'mceNonEditable',
          toolbar_mode: 'sliding',
          contextmenu: 'link image table',
          skin: useDarkMode ? 'oxide-dark' : 'oxide',
          content_css: useDarkMode ? 'dark' : 'default',
          // images_upload_url: '/mo/storage',
          images_upload_url: '/api/upload_tinymce_image',
          automatic_uploads: true,





          setup: (editor)=> {
              editor.on('change', ()=> {
                editor.save();
                this.value = this.field.value = editor.getContent();                
              });
            }
      });
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.fieldAttribute, this.value || '')
    },
    
  },
}
</script>