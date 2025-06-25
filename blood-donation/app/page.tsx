import { ChevronLeft, ChevronRight, Search, MapPin, Send } from "lucide-react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Textarea } from "@/components/ui/textarea"
import Link from "next/link"
import DonorCarousel from "@/components/donor-carousel"
import SponsorCarousel from "@/components/sponsor-carousel"
import TestimonialCarousel from "@/components/testimonial-carousel"

export default function Home() {
  return (
    <main className="min-h-screen">
      {/* Hero Section with Blood Cells Background */}
      <section className="relative bg-gradient-to-r from-red-100 to-red-50">
        <div className="absolute inset-0 bg-[url('/blood-cells-bg.png')] bg-cover bg-center opacity-40"></div>
        <div className="container mx-auto px-4 py-12 relative">
          <div className="flex justify-center">
            <div className="relative w-full max-w-4xl">
              <DonorCarousel />
            </div>
          </div>
        </div>
      </section>

      {/* Search Section */}
      <section className="py-8 bg-gradient-to-r from-red-900 to-red-700 shadow-md">
        <div className="container mx-auto px-4">
          <div className="bg-white/90 rounded-lg p-6 max-w-4xl mx-auto shadow-lg">
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
              <div className="md:col-span-1">
                <Input type="text" placeholder="Enter Keywords" className="w-full" />
              </div>
              <div className="md:col-span-1">
                <select className="w-full h-10 rounded-md border border-input bg-background px-3 py-2">
                  <option>Blood Categories</option>
                  <option>A+</option>
                  <option>A-</option>
                  <option>B+</option>
                  <option>B-</option>
                  <option>AB+</option>
                  <option>AB-</option>
                  <option>O+</option>
                  <option>O-</option>
                </select>
              </div>
              <div className="md:col-span-1">
                <select className="w-full h-10 rounded-md border border-input bg-background px-3 py-2">
                  <option>Area of Use</option>
                  <option>Hospital</option>
                  <option>Surgery</option>
                  <option>Emergency</option>
                  <option>Accident</option>
                </select>
              </div>
              <div className="md:col-span-1">
                <select className="w-full h-10 rounded-md border border-input bg-background px-3 py-2">
                  <option>Donation Date</option>
                  <option>Last Week</option>
                  <option>Last Month</option>
                  <option>Last 3 Months</option>
                  <option>Last 6 Months</option>
                </select>
              </div>
            </div>
            <div className="mt-4 text-center">
              <Button className="bg-red-800 hover:bg-red-900 text-white px-8">
                <Search className="h-4 w-4 mr-2" /> Search Now
              </Button>
            </div>
          </div>
        </div>
      </section>

      {/* Live Donor Summary */}
      <section className="py-12 bg-white">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-10 text-gray-800">LIVE DONOR SUMMARY</h2>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div className="bg-red-500 text-white p-6 rounded-md text-center">
              <h3 className="text-xl font-semibold mb-2">Total Donors: 230</h3>
            </div>
            <div className="bg-green-500 text-white p-6 rounded-md text-center">
              <h3 className="text-xl font-semibold mb-2">Available Donors: 45</h3>
            </div>
            <div className="bg-blue-500 text-white p-6 rounded-md text-center">
              <h3 className="text-xl font-semibold mb-2">Total Donation: 550</h3>
            </div>
          </div>

          <div className="mt-6 max-w-4xl mx-auto">
            <div className="bg-red-500 text-white p-4 rounded-md text-center">
              <p>Blood donation saves lives! Join us and be a hero today.</p>
              <p>Every drop counts - help those in need by donating blood.</p>
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-12 bg-gray-50">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-10 text-gray-800">
            WHAT IS SAYS OUR SURVIVOR HEROES AND FRIENDS
          </h2>

          <div className="max-w-4xl mx-auto">
            <TestimonialCarousel />
          </div>
        </div>
      </section>

      {/* Sponsors */}
      <section className="py-12 bg-white">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-10 text-gray-800">OUR ESTEEMED SPONSORS</h2>

          <div className="max-w-5xl mx-auto relative">
            <SponsorCarousel />
            <button className="absolute left-0 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100 z-10">
              <ChevronLeft className="h-6 w-6 text-red-800" />
            </button>
            <button className="absolute right-0 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100 z-10">
              <ChevronRight className="h-6 w-6 text-red-800" />
            </button>
          </div>
        </div>
      </section>

      {/* Contact Us */}
      <section className="py-12 bg-black bg-opacity-80 text-white relative">
        <div className="absolute inset-0 bg-[url('/blood-cells-dark.png')] bg-cover bg-center opacity-20"></div>
        <div className="container mx-auto px-4 relative">
          <h2 className="text-3xl font-bold text-center mb-10">CONTACT US</h2>

          <div className="max-w-md mx-auto bg-white rounded-md p-6">
            <div className="space-y-4">
              <Input type="text" placeholder="Your Name" className="bg-white text-black" />
              <Input type="email" placeholder="Email" className="bg-white text-black" />
              <Textarea placeholder="Message" className="bg-white text-black" rows={4} />
              <div className="flex justify-between">
                <Button className="bg-red-800 hover:bg-red-900 text-white px-8">
                  <Send className="h-4 w-4 mr-2" /> SEND
                </Button>
                <Button variant="outline" className="border-red-800 text-red-800 hover:bg-red-50">
                  <MapPin className="h-4 w-4 mr-2" /> MAP
                </Button>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-gray-900 text-white py-12">
        <div className="container mx-auto px-4">
          <div className="text-center mb-8">
            <h2 className="text-2xl font-bold">OneTwoOneFour</h2>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-5xl mx-auto border-t border-gray-700 pt-8">
            <div>
              <h3 className="text-lg font-semibold mb-4">Useful link</h3>
              <ul className="space-y-2">
                <li>
                  <Link href="/" className="text-gray-300 hover:text-white">
                    Home
                  </Link>
                </li>
                <li>
                  <Link href="/about" className="text-gray-300 hover:text-white">
                    About
                  </Link>
                </li>
                <li>
                  <Link href="/gallery" className="text-gray-300 hover:text-white">
                    Gallery
                  </Link>
                </li>
                <li>
                  <Link href="/faq" className="text-gray-300 hover:text-white">
                    FAQ
                  </Link>
                </li>
                <li>
                  <Link href="/resources" className="text-gray-300 hover:text-white">
                    Resources
                  </Link>
                </li>
                <li>
                  <Link href="/contact" className="text-gray-300 hover:text-white">
                    Contact Us
                  </Link>
                </li>
              </ul>
            </div>

            <div>
              <h3 className="text-lg font-semibold mb-4">Portfolio</h3>
              <ul className="space-y-2">
                <li>
                  <Link href="/licenses" className="text-gray-300 hover:text-white">
                    Licenses
                  </Link>
                </li>
                <li>
                  <Link href="/jobs" className="text-gray-300 hover:text-white">
                    Jobs
                  </Link>
                </li>
                <li>
                  <Link href="/donors" className="text-gray-300 hover:text-white">
                    Donors
                  </Link>
                </li>
                <li>
                  <Link href="/faq" className="text-gray-300 hover:text-white">
                    FAQ
                  </Link>
                </li>
                <li>
                  <Link href="/resources" className="text-gray-300 hover:text-white">
                    Resources
                  </Link>
                </li>
                <li>
                  <Link href="/contact" className="text-gray-300 hover:text-white">
                    Contact Us
                  </Link>
                </li>
              </ul>
            </div>

            <div>
              <h3 className="text-lg font-semibold mb-4">Contact Us</h3>
              <ul className="space-y-2">
                <li className="flex items-start">
                  <MapPin className="h-5 w-5 mr-2 text-red-500 flex-shrink-0 mt-0.5" />
                  <span>+880 1234567</span>
                </li>
                <li className="flex items-start">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className="h-5 w-5 mr-2 text-red-500 flex-shrink-0 mt-0.5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                  <span>demo@gmail.com</span>
                </li>
              </ul>
            </div>

            <div>
              <h3 className="text-lg font-semibold mb-4">Social Link</h3>
              <p className="mb-4">It is a long established fact that a reader will be</p>
              <div className="flex space-x-3">
                <a href="#" className="bg-white rounded-full p-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className="h-5 w-5 text-red-800"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                  </svg>
                </a>
                <a href="#" className="bg-white rounded-full p-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className="h-5 w-5 text-red-800"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                  </svg>
                </a>
                <a href="#" className="bg-white rounded-full p-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className="h-5 w-5 text-red-800"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                  </svg>
                </a>
                <a href="#" className="bg-white rounded-full p-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className="h-5 w-5 text-red-800"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                  </svg>
                </a>
              </div>
            </div>
          </div>

          <div className="text-center text-sm text-gray-400 mt-12">
            <p>2023 All Rights Reserved. Design by AIO Conversion Limited</p>
          </div>
        </div>
      </footer>
    </main>
  )
}
