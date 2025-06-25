"use client"

import { useState, useEffect } from "react"
import { ChevronLeft, ChevronRight } from "lucide-react"
import Image from "next/image"

export default function DonorCarousel() {
  const [currentSlide, setCurrentSlide] = useState(0)

  const slides = [
    {
      title: "Blood Donation",
      description: "Donating blood is quick, easy and safe",
      image: "/blood-donation-slide1.png",
    },
    {
      title: "Save Lives",
      description: "Your donation can save up to 3 lives",
      image: "/blood-donation-slide2.png",
    },
    {
      title: "Be a Hero",
      description: "Give the gift of life by donating blood today",
      image: "/blood-donation-slide3.png",
    },
  ]

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentSlide((prev) => (prev === slides.length - 1 ? 0 : prev + 1))
    }, 5000)

    return () => clearInterval(interval)
  }, [slides.length])

  const nextSlide = () => {
    setCurrentSlide((prev) => (prev === slides.length - 1 ? 0 : prev + 1))
  }

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev === 0 ? slides.length - 1 : prev - 1))
  }

  return (
    <div className="relative w-full h-[400px] md:h-[500px] overflow-hidden rounded-lg">
      {slides.map((slide, index) => (
        <div
          key={index}
          className={`absolute inset-0 transition-opacity duration-1000 ${
            index === currentSlide ? "opacity-100" : "opacity-0"
          }`}
        >
          {/* Background image with overlay */}
          <div className="absolute inset-0 bg-red-700/60">
            <Image
              src={slide.image || "/placeholder.svg"}
              alt={slide.title}
              fill
              className="object-cover mix-blend-multiply"
              priority={index === 0}
            />
          </div>

          {/* Content */}
          <div className="absolute inset-0 flex items-center justify-center">
            <div className="bg-white p-6 md:p-8 rounded-lg text-center max-w-xs md:max-w-sm mx-4">
              <h2 className="text-2xl md:text-3xl font-bold text-red-700 mb-2">{slide.title}</h2>
              <p className="text-gray-800">{slide.description}</p>
            </div>
          </div>
        </div>
      ))}

      {/* Navigation arrows */}
      <button
        onClick={prevSlide}
        className="absolute left-4 top-1/2 -translate-y-1/2 bg-white w-10 h-10 rounded-full flex items-center justify-center shadow-md hover:bg-gray-100 z-10"
        aria-label="Previous slide"
      >
        <ChevronLeft className="h-6 w-6 text-gray-600" />
      </button>

      <button
        onClick={nextSlide}
        className="absolute right-4 top-1/2 -translate-y-1/2 bg-white w-10 h-10 rounded-full flex items-center justify-center shadow-md hover:bg-gray-100 z-10"
        aria-label="Next slide"
      >
        <ChevronRight className="h-6 w-6 text-gray-600" />
      </button>

      {/* Slide indicators */}
      <div className="absolute bottom-6 left-0 right-0 flex justify-center space-x-2 z-10">
        {slides.map((_, index) => (
          <button
            key={index}
            onClick={() => setCurrentSlide(index)}
            className={`w-2.5 h-2.5 rounded-full transition-colors ${
              index === currentSlide ? "bg-white" : "bg-white/40"
            }`}
            aria-label={`Go to slide ${index + 1}`}
          />
        ))}
      </div>
    </div>
  )
}
