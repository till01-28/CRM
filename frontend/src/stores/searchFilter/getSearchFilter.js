import { ref, computed} from "vue";

export function useSearchFilter(searches){
    const selectedSearch = ref('all')

    const visibleSearches = computed(() => {
        if (selectedSearch.value === 'all') {
            return searches
        }

        return searches.filter(search => search.id === selectedSearch.value)
    })

    return {selectedSearch, visibleSearches}
}