"use client"

import { useState, useEffect } from "react"
import { ChevronLeft, ChevronRight } from "lucide-react"
import Image from "next/image"

export default function TestimonialCarousel() {
  const [currentSlide, setCurrentSlide] = useState(0)

  const testimonials = [
    {
      id: 1,
      name: "John Doe",
      image: "/testimonial-1.png",
      content:
        "Has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors",
      role: "Blood Recipient",
    },
    {
      id: 2,
      name: "Jane Smith",
      image: "/testimonial-2.png",
      content:
        "The blood donation saved my life after a serious accident. I'm forever grateful to the donors who took the time to give blood. Now I'm a regular donor myself to pay it forward.",
      role: "Blood Recipient",
    },
    {
      id: 3,
      name: "Robert Johnson",
      image: "/testimonial-3.png",
      content:
        "I've been donating blood for over 10 years now. It's such a simple way to make a huge difference in someone's life. The staff are always friendly and the process is quick and easy.",
      role: "Regular Donor",
    },
  ]

  const nextSlide = () => {
    setCurrentSlide((prev) => (prev === testimonials.length - 1 ? 0 : prev + 1))
  }

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev === 0 ? testimonials.length - 1 : prev - 1))
  }

  useEffect(() => {
    const interval = setInterval(() => {
      nextSlide()
    }, 8000)

    return () => clearInterval(interval)
  }, [])

  return (
    <div className="relative border border-gray-200 rounded-lg p-6 bg-white shadow-md">
      {testimonials.map((testimonial, index) => (
        <div
          key={testimonial.id}
          className={`transition-opacity duration-500 ${
            index === currentSlide ? "opacity-100" : "opacity-0 absolute inset-0"
          }`}
        >
          <div className="flex flex-col md:flex-row items-center gap-6 p-4">
            <div className="w-24 h-24 relative flex-shrink-0">
              <Image
                src={testimonial.image || "/placeholder.svg"}
                alt={testimonial.name}
                fill
                className="rounded-full object-cover"
              />
            </div>
            <div>
              <p className="text-gray-700 mb-4">{testimonial.content}</p>
              <h3 className="font-bold text-red-800">{testimonial.name}</h3>
              <p className="text-sm text-gray-600">{testimonial.role}</p>
            </div>
          </div>
        </div>
      ))}

      <div className="absolute bottom-4 right-4 flex space-x-2">
        <button
          onClick={prevSlide}
          className="p-1 rounded-full bg-gray-200 hover:bg-gray-300"
          aria-label="Previous testimonial"
        >
          <ChevronLeft className="h-5 w-5 text-gray-700" />
        </button>
        <button
          onClick={nextSlide}
          className="p-1 rounded-full bg-gray-200 hover:bg-gray-300"
          aria-label="Next testimonial"
        >
          <ChevronRight className="h-5 w-5 text-gray-700" />
        </button>
      </div>
    </div>
  )
}
