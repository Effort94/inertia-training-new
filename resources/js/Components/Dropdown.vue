<template>
    <div id="app">
        <AppDropdown>
            <template slot="toggler">
                <button>Toggle</button>
            </template>
            <AppDropdownContent>
                <AppDropdownItem>Action 1</AppDropdownItem>
                <AppDropdownItem>Action 2</AppDropdownItem>
                <AppDropdownItem>Action 3</AppDropdownItem>
            </AppDropdownContent>
        </AppDropdown>
    </div>
</template>

<script>
import AppDropdown from './components/AppDropdown.vue'
import AppDropdownContent from './components/AppDropdownContent.vue'
import AppDropdownItem from './components/AppDropdownItem.vue'
export default {
    name: 'app',
    components: {
        AppDropdown,
        AppDropdownContent,
        AppDropdownItem,
    }
}
</script>
