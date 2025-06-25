import type React from "react"
import "./globals.css"
import type { Metadata } from "next"
import { Inter } from "next/font/google"
import { ThemeProvider } from "@/components/theme-provider"
import Link from "next/link"

const inter = Inter({ subsets: ["latin"] })

export const metadata: Metadata = {
  title: "এসএসএফ ১২ ও এইচএসএফ ১৪ ব্যাচ - Blood Donation",
  description: "Blood donation platform for SSF 12 and HSF 14 batch",
    generator: 'v0.dev'
}

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode
}>) {
  return (
    <html lang="en">
      <body className={inter.className}>
        <ThemeProvider attribute="class" defaultTheme="light">
          <header>
            {/* Single Row Header */}
            <div className="bg-red-800 text-white">
              <div className="container mx-auto px-4">
                <div className="flex items-center justify-between py-2">
                  {/* Logo */}
                  <Link href="/" className="flex items-center">
                    <img src="/blood-drop-logo.png" alt="Blood Donation Logo" className="h-10 w-auto" />
                    <div className="ml-2">
                      <h1 className="text-white font-bold text-sm leading-tight">এসএসএফ ১২ ও এইচএসএফ ১৪ ব্যাচ</h1>
                      <p className="text-white/80 text-xs">রক্তের বন্ধন অটুট থাক, জীবন বাঁচাতে রক্ত দিন</p>
                    </div>
                  </Link>

                  {/* Navigation */}
                  <nav className="hidden md:block">
                    <ul className="flex space-x-1">
                      <li>
                        <Link href="/" className="block px-3 py-2 hover:bg-red-900 font-medium text-sm">
                          HOME
                        </Link>
                      </li>
                      <li>
                        <Link href="/about-us" className="block px-3 py-2 hover:bg-red-900 font-medium text-sm">
                          ABOUT US
                        </Link>
                      </li>
                      <li>
                        <Link href="/donor-list" className="block px-3 py-2 hover:bg-red-900 font-medium text-sm">
                          DONOR LIST
                        </Link>
                      </li>
                      <li>
                        <Link href="/gallery" className="block px-3 py-2 hover:bg-red-900 font-medium text-sm">
                          GALLERY
                        </Link>
                      </li>
                      <li>
                        <Link href="/emergency" className="block px-3 py-2 hover:bg-red-900 font-medium text-sm">
                          EMERGENCY CONTACT
                        </Link>
                      </li>
                    </ul>
                  </nav>

                  {/* Mobile Menu Button */}
                  <button className="md:hidden p-2 focus:outline-none" aria-label="Toggle menu">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                  </button>

                  {/* Login/Register */}
                  <div className="hidden md:flex items-center space-x-2">
                    <Link href="/login" className="px-3 py-1 bg-white text-red-800 rounded text-xs hover:bg-gray-100">
                      Login
                    </Link>
                    <Link href="/register" className="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                      Register
                    </Link>
                  </div>
                </div>
              </div>
            </div>

            {/* Mobile Navigation Menu - Hidden by default */}
            <div className="md:hidden hidden bg-red-800 text-white" id="mobile-menu">
              <div className="px-2 pt-2 pb-3 space-y-1">
                <Link href="/" className="block px-3 py-2 hover:bg-red-900 font-medium">
                  HOME
                </Link>
                <Link href="/about-us" className="block px-3 py-2 hover:bg-red-900 font-medium">
                  ABOUT US
                </Link>
                <Link href="/donor-list" className="block px-3 py-2 hover:bg-red-900 font-medium">
                  DONOR LIST
                </Link>
                <Link href="/gallery" className="block px-3 py-2 hover:bg-red-900 font-medium">
                  GALLERY
                </Link>
                <Link href="/emergency" className="block px-3 py-2 hover:bg-red-900 font-medium">
                  EMERGENCY CONTACT
                </Link>
                <div className="flex space-x-2 mt-3 px-3">
                  <Link
                    href="/login"
                    className="px-3 py-1 bg-white text-red-800 rounded text-xs hover:bg-gray-100 flex-1 text-center"
                  >
                    Login
                  </Link>
                  <Link
                    href="/register"
                    className="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700 flex-1 text-center"
                  >
                    Register
                  </Link>
                </div>
              </div>
            </div>

            {/* Announcement Bar */}
            <div className="bg-red-800 text-white py-1 px-4 text-sm border-t border-red-700">
              <marquee>শুভ বিজয় দিবসের শুভেচ্ছা ও অভিনন্দন</marquee>
            </div>
          </header>

          {children}

          <script
            dangerouslySetInnerHTML={{
              __html: `
                document.addEventListener('DOMContentLoaded', function() {
                  const mobileMenuBtn = document.querySelector('button[aria-label="Toggle menu"]');
                  const mobileMenu = document.getElementById('mobile-menu');
                  
                  if (mobileMenuBtn && mobileMenu) {
                    mobileMenuBtn.addEventListener('click', function() {
                      mobileMenu.classList.toggle('hidden');
                    });
                  }
                });
              `,
            }}
          />
        </ThemeProvider>
      </body>
    </html>
  )
}
