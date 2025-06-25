"use client"

import { useState, useEffect } from "react"
import Image from "next/image"

export default function SponsorCarousel() {
  const sponsors = [
    { id: 1, name: "Company Name 1", logo: "/sponsor-logo.png" },
    { id: 2, name: "Company Name 2", logo: "/sponsor-logo.png" },
    { id: 3, name: "Company Name 3", logo: "/sponsor-logo.png" },
    { id: 4, name: "Company Name 4", logo: "/sponsor-logo.png" },
    { id: 5, name: "Company Name 5", logo: "/sponsor-logo.png" },
    { id: 6, name: "Company Name 6", logo: "/sponsor-logo.png" },
  ]

  const [visibleSponsors, setVisibleSponsors] = useState<number[]>([0, 1, 2, 3, 4, 5])

  useEffect(() => {
    const interval = setInterval(() => {
      setVisibleSponsors((prev) => {
        const newVisible = [...prev]
        // Rotate the sponsors
        const first = newVisible.shift() as number
        newVisible.push(first)
        return newVisible
      })
    }, 3000)

    return () => clearInterval(interval)
  }, [])

  return (
    <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 px-8">
      {visibleSponsors.map((index) => {
        const sponsor = sponsors[index]
        return (
          <div
            key={sponsor.id}
            className="border border-gray-200 rounded-lg p-4 flex flex-col items-center justify-center bg-white hover:shadow-md transition-shadow"
          >
            <div className="relative w-20 h-20">
              <Image src={sponsor.logo || "/placeholder.svg"} alt={sponsor.name} fill className="object-contain" />
            </div>
            <p className="mt-2 text-sm text-center text-gray-700">{sponsor.name}</p>
          </div>
        )
      })}
    </div>
  )
}
