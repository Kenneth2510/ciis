"use client"

import * as React from "react"
import {
    LayoutGrid,
    SquareTerminal,
    Users,
    Building,
    Logs,
    FileDown,
} from "lucide-react"

import { NavMain } from "@/components/nav-main"
import { NavUser } from "@/components/nav-user"
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarRail,
} from "@/components/ui/sidebar"
import { Link } from "@inertiajs/react"
import AppLogo from "./app-logo"

const navMain = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: "Users Management",
        url: "#",
        icon: Users,
        isActive: true,
        items: [
            {
                title: "Users",
                url: "#",
            },
            {
                title: "Roles",
                url: "#",
            },
            {
                title: "Permissions",
                url: "#",
            },
        ],
    },
    {
        title: "Office Management",
        url: "#",
        icon: Building,
        isActive: true,
        items: [
            {
                title: "Branches",
                url: "#",
            },
            {
                title: "Groups",
                url: "#",
            },
            {
                title: "Divisions",
                url: "#",
            },
            {
                title: "Departments",
                url: "#",
            },
            {
                title: "Sections",
                url: "#",
            },
        ],
    },
    {
        title: 'Audit Logs',
        href: '#',
        icon: Logs,
    },
    {
        title: 'Reports',
        href: '#',
        icon: FileDown,
    },
]

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>
            <SidebarContent>
                <NavMain items={navMain} />
            </SidebarContent>
            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
            <SidebarRail />
        </Sidebar>
    )
}
