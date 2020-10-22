<template>
    <CDropdown
        inNav
        class="c-header-nav-items"
        placement="bottom-end"
        add-menu-classes="pt-0"
    >
        <template #toggler>
            <CHeaderNavLink>
                <div class="c-avatar">
                    <CIcon name="cil-user"></CIcon>
                </div>
            </CHeaderNavLink>
        </template>
        <CDropdownHeader tag="div" class="text-center" color="light">
            <strong>Account</strong>
        </CDropdownHeader>
        <CDropdownItem @click.prevent="$auth.logout()">
            <CIcon name="cil-lock-locked" /> Logout
        </CDropdownItem>
    </CDropdown>
</template>

<script>
export default {
    name: "TheHeaderDropdownAccnt",
    methods: {}
};
</script>

<style lang="scss" scoped>
.c-avatar {
    border-radius: 50%;
    border: 1px solid #ddd;

    .c-icon {
        margin-right: 0;
    }
}

.c-icon {
    margin-right: 0.3rem;
}
</style>
