<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div class="mo-text-ai-field-container">
        <!-- <input -->
        <trix-editor
        :id="field.attribute"
        type="text"
        class="w-full form-control form-input form-control-bordered"
        :class="errorClasses"
        :placeholder="field.name"
        v-model="value"
        :parent="field.parent"
      ></trix-editor>
      <button @click="moInputAi" type="button" class="mo-text-ai-field-btn">AI</button>
      </div>
      

    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  methods: {


    async moInputAi() {
      // alert('hello world')
      const nameField = document.querySelector('input[dusk="name"]')?.value;
      const addressField = document.querySelector('input[dusk="address"]')?.value;
      const dateOfBirthField = document.querySelector('input[dusk="date_of_birth"]')?.value;
      const PhoneField = document.querySelector('input[dusk="phone"]')?.value;
      const genderField = document.querySelector('select[dusk="gender"]')?.value;
      const nationalityField = document.querySelector('input[dusk="nationality"]')?.value;
      const emailField = document.querySelector('input[dusk="email"]')?.value;

      console.log(nameField) ;
      console.log(addressField) ;
      console.log(dateOfBirthField) ;
      console.log(PhoneField) ;
      console.log(genderField) ;
      console.log(nationalityField) ;
      console.log(emailField) ;

      // let dataJson = '';
      let finalData = '' ;

      let moValue = '';
      if(this.value === ''){
        moValue = prompt("من فضلك ادخل اي داتا تساعدنا في مساعدتك");
        console.log(moValue)
      }else{
        moValue = this.value
      }

      try {
        const response = await fetch("http://csv.test/api/test",{
          method: 'POST',
          headers: {
            'Content-Type': 'application/json' // تأكد من تحديد نوع البيانات
          },

          body: JSON.stringify({
            "name": nameField,
            "address": addressField,
            "date_of_birth": dateOfBirthField,
            "phone": PhoneField,
            "gender": genderField,
            "nationality": nationalityField,
            "email": emailField,
            "field_name" : this.field.name,
            "parent" : this.field.parent,
            "value" : moValue
          })
        });
        // this.posts = await response.json();
        let dataJson = await response.json();
        
        finalData = dataJson.candidates[0].content.parts[0].text
        console.log('final1',dataJson)

      } catch (error) {
          console.log("Error fetching data:", error);
      }

      
      console.log('final',finalData)

      // const output = 'VALUE' ;
      const con =  confirm(`data is : ${finalData}`);
      if(con){
        this.value = nameField.value ;
      }
      
    },
    
    
    
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
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
