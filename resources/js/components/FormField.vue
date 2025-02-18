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
    // setInitialValue() {
    //   this.value = this.field.value || ''
    // },



    async moInputAi(editor) {

      // console.log(editor.getContent());
      // return 0;
      // console.log(this.field);
      let finalData = '' ;

      let moValue = '';
      if(editor.getContent() === ''){
        moValue = alert("من فضلك ادخل اي داتا تساعدنا في مساعدتك");
        return 0;
      }else{
        moValue = editor.getContent()
      }

      try {
        
        const response = await fetch("/api/test",{
          method: 'POST',
          headers: {
            'Content-Type': 'application/json' // تأكد من تحديد نوع البيانات
          },


          body: JSON.stringify({
            // "name": nameField,
            // "address": addressField,
            // "date_of_birth": dateOfBirthField,
            // "phone": PhoneField,
            // "gender": genderField,
            // "nationality": nationalityField,
            // "email": emailField,
            "field_name" : this.field.attribute,
            // "field_name" : this.field.name,
            // "parent" : this.field.parent,
            "value" : editor.getContent()
          })
        });


        
        // this.posts = await response.json();


        let dataJson = await response.json();

        finalData = JSON.parse(dataJson.candidates[0].content.parts[0].text).key

        

        

      } catch (error) {
          console.log("Error fetching data:", error);
      }


      

      // const output = 'VALUE' ;
      
      if(finalData){
        editor.setContent(finalData);
        this.value = finalData ;
      }

    },




    setEditor () {
        const useDarkMode = false ;
        tinymce.init({
          "selector": "#" + this.field.attribute,
          plugins: 'searchreplace autosave save code fullscreen pagebreak advlist lists ',
          menubar: '',
          toolbar: "undo redo | blocks bold align numlist bullist code fullscreen pagebreak customButton  ",

          height: 600,

          setup: (editor)=> {


            editor.ui.registry.addButton('customButton', {
            text: 'AI',
            tooltip: 'AI',
            // icon: 'comment',
            onAction: () => {
              this.moInputAi(editor);
              // editor.insertContent('<strong>نص مخصص</strong>');
            }
          });



              editor.on('change', ()=> {
                // editor.save();
                this.value = this.field.value = editor.getContent();
              });

              // editor.on('keyup', () => {
              //   alert('ggg')
              //   // editor.save();
              //   this.value = this.field.value = editor.getContent();
              // });



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