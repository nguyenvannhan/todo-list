export default [
    {
        _name: "CSidebarNav",
        _children: [
            {
                _name: "CSidebarNavItem",
                name: "All",
                to: { name: "Todo" },
                icon: "cil-speedometer"
            },
            {
                _name: "CSidebarNavItem",
                name: "Doing",
                to: { name: "Todo", params: { status: "doing" } },
                icon: "cil-x-circle"
            },
            {
                _name: "CSidebarNavItem",
                name: "Completed",
                to: { name: "Todo", params: { status: "completed" } },
                icon: "cil-check-circle"
            }
        ]
    }
];
