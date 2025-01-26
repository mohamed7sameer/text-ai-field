import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'
import PreviewField from './components/PreviewField'

Nova.booting((app, store) => {
  app.component('index-text-ai-field', IndexField)
  app.component('detail-text-ai-field', DetailField)
  app.component('form-text-ai-field', FormField)
  // app.component('preview-text-ai-field', PreviewField)
})
