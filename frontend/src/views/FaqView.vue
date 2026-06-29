<template>
  <div class="faq-layout">
    <!-- ─── ПОСЛУГИ section ───────────────────────────────────────── -->
    <FaqSectionLabel title="ПОСЛУГИ" />
    <FaqServiceRow />

    <!-- ─── FAQ section ──────────────────────────────────────────── -->
    <FaqSectionLabel title="FAQ" />

    <!-- Desktop grid (3 columns) -->
    <FaqGrid :items="faqItems" />

    <!-- Mobile accordion -->
    <FaqAccordion :items="faqItems" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import FaqSectionLabel from '@/components/faq/FaqSectionLabel.vue'
import FaqServiceRow from '@/components/faq/FaqServiceRow.vue'
import FaqGrid from '@/components/faq/FaqGrid.vue'
import FaqAccordion from '@/components/faq/FaqAccordion.vue'

// Fallback demo data matching Figma content
const defaultFaqs = [
  {
    id: 1,
    question: 'Говерла здіймається над Карпатами, збираючи мандрівників, що прагнуть підкорити її вершину і відчути свободу.',
    answer:   'Колись ця полонина була важливим пасовищем для овець та великої рогатої худоби, а її назва походить від слова «руно» – густе овече хутро.',
  },
  {
    id: 2,
    question: 'На Піп Івані мовчазні руїни обсерваторії розповідають історії минулого крізь вітри й хмари часу.',
    answer:   'Колись ця полонина була важливим пасовищем для овець та великої рогатої худоби, а її назва походить від слова «руно» – густе овече хутро.',
  },
  {
    id: 3,
    question: 'Петрос – це виклик, пригоди та сила природи, що відчувається кожним кроком на його схилах і вершинах.',
    answer:   'Колись ця полонина була важливим пасовищем для овець та великої рогатої худоби, а її назва походить від слова «руно» – густе овече хутро.',
  },
  {
    id: 4,
    question: 'Ай-Петрі здіймається над Кримом, розливаючи перед очима безмежні простори моря, гір і неба в єдності.',
    answer:   'Колись ця полонина була важливим пасовищем для овець та великої рогатої худоби, а її назва походить від слова «руно» – густе овече хутро.',
  },
  {
    id: 5,
    question: 'Озеро Бребенескул, оточене гірськими хребтами, ховає у своїх водах відображення зірок та спокій вітрів.',
    answer:   'Колись ця полонина була важливим пасовищем для овець та великої рогатої худоби, а її назва походить від слова «руно» – густе овече хутро.',
  },
]

const faqItems = ref(defaultFaqs)

onMounted(async () => {
  try {
    const { data } = await axios.get('/api/v1/faqs')
    if (data?.length) {
      faqItems.value = data.map(item => ({
        id:       item.id,
        question: item.question,
        answer:   item.answer,
      }))
    }
  } catch {
    // use defaults
  }
})
</script>

<style scoped>
.faq-layout {
  min-height: 100vh;
  background-color: #000;
  color: var(--color-white);
  overflow-x: hidden;
}

/* Remove overflow:hidden from html/body for this page */
:global(.faq-page) {
  overflow: auto;
}
</style>
